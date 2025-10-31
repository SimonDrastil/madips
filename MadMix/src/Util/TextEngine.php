<?php
declare(strict_types=1);

namespace MadMix\Util;

use MadMix\Model\WordBank;

final class TextEngine
{
    /** @var array<string,string> */
    private array $variables = [];
    /** @var array<string,string> */
    private array $errors = [];
    /** @var array<string,bool> */
    private array $used = [];

    /**
     * Render the template with provided inputs.
     *
     * @param array<string,string> $inputs
     * @return array{content:string,errors:array<string,string>}
     */
    public function render(string $template, array $inputs = [], bool $deterministic = true): array
    {
        $this->variables = [];
        $this->errors = [];
        $this->used = [];

        $pattern = '/\{((?>[^{}]+|(?R))*)\}/';
        $result = preg_replace_callback($pattern, function (array $matches) use ($inputs, $deterministic) {
            $token = $matches[1];
            $parsed = $this->parseToken($token);

            if ($parsed['type'] === 'set') {
                $value = $this->resolvePlaceholder($parsed['value'], $inputs, $deterministic);
                if ($value === null) {
                    $this->errors[$parsed['key']] = 'Missing value for variable ' . $parsed['key'];
                    return '';
                }
                $this->variables[$parsed['key']] = $value;
                return '';
            }

            $value = $this->resolve($parsed, $inputs, $deterministic);
            if ($value === null) {
                $this->errors[$parsed['key']] = 'Missing value for ' . $parsed['key'];
                return '[' . $parsed['key'] . ']';
            }

            return $value;
        }, $template) ?? $template;

        return ['content' => $result, 'errors' => $this->errors];
    }

    /**
     * @return array<string,string>
     */
    public function placeholders(string $template): array
    {
        $pattern = '/\{((?>[^{}]+|(?R))*)\}/';
        $placeholders = [];
        if (preg_match_all($pattern, $template, $matches)) {
            foreach ($matches[1] as $token) {
                $parsed = $this->parseToken($token);
                if ($parsed['type'] === 'set') {
                    continue;
                }
                $placeholders[$parsed['key']] = $parsed['pos'];
            }
        }

        return $placeholders;
    }

    /**
     * @param array<string,mixed> $inputs
     */
    private function resolve(array $parsed, array $inputs, bool $deterministic): ?string
    {
        $key = $parsed['key'];
        if (isset($this->variables[$key])) {
            return $this->applyModifiers($this->variables[$key], $parsed['modifiers']);
        }

        if (isset($inputs[$key]) && $inputs[$key] !== '') {
            $value = $inputs[$key];
        } elseif ($parsed['type'] === 'choice') {
            $choices = $parsed['value'];
            $value = $choices[array_rand($choices)];
        } elseif (!$deterministic) {
            $value = $this->randomWord($parsed['pos']) ?? null;
        } else {
            $value = null;
        }

        if ($value === null) {
            return null;
        }

        if (isset($this->used[$value])) {
            $suffix = random_int(10, 99);
            $value .= $suffix;
        }

        $this->used[$value] = true;

        return $this->applyModifiers($value, $parsed['modifiers']);
    }

    /**
     * @param array<string,mixed> $inputs
     */
    private function resolvePlaceholder(array $parsed, array $inputs, bool $deterministic): ?string
    {
        return $this->resolve($parsed, $inputs, $deterministic);
    }

    private function randomWord(string $pos): ?string
    {
        $record = WordBank::randomByPos($pos);
        return $record['word'] ?? null;
    }

    /**
     * @param array<int,string> $modifiers
     */
    private function applyModifiers(string $value, array $modifiers): string
    {
        foreach ($modifiers as $modifier) {
            $value = match ($modifier) {
                'upper' => mb_strtoupper($value),
                'title' => mb_convert_case($value, MB_CASE_TITLE_SIMPLE),
                'cap' => mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1),
                default => $value,
            };
        }

        return $value;
    }

    /**
     * @return array{type:string,key:string,pos:string,modifiers:array<int,string>,value:mixed}
     */
    private function parseToken(string $token): array
    {
        $segments = explode('|', $token);
        $main = array_shift($segments);
        $modifiers = $segments;

        if (str_starts_with($main, 'set:')) {
            $rest = substr($main, 4);
            [$var, $raw] = array_map('trim', explode('=', $rest, 2));
            $inner = trim($raw, '{}');
            $placeholder = $this->parseToken($inner);
            return [
                'type' => 'set',
                'key' => $var,
                'pos' => $placeholder['pos'],
                'modifiers' => [],
                'value' => $placeholder,
            ];
        }

        if ($main === 'choice') {
            return [
                'type' => 'choice',
                'key' => 'choice_' . uniqid('', true),
                'pos' => 'choice',
                'modifiers' => [],
                'value' => $segments,
            ];
        }

        $parts = explode(':', $main);
        $key = $parts[0];
        $pos = $parts[0];
        if (isset($parts[1]) && $parts[1] !== '') {
            if (str_contains($parts[1], '=')) {
                [$metaKey] = array_map('trim', explode('=', $parts[1], 2));
                if ($metaKey === 'weight') {
                    $pos = $parts[0];
                }
            } else {
                $pos = $parts[1];
            }
        }

        return [
            'type' => 'placeholder',
            'key' => $key,
            'pos' => $pos,
            'modifiers' => $modifiers,
            'value' => null,
        ];
    }
}
