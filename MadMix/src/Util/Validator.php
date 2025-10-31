<?php
declare(strict_types=1);

namespace MadMix\Util;

final class Validator
{
    /**
     * @param array<string,mixed> $input
     * @param array<string,array<string,mixed>> $rules
     * @return array<string,string>
     */
    public static function validate(array $input, array $rules): array
    {
        $errors = [];
        foreach ($rules as $field => $config) {
            $value = $input[$field] ?? null;
            if (($config['required'] ?? false) && ($value === null || $value === '')) {
                $errors[$field] = 'This field is required.';
                continue;
            }

            if ($value === null || $value === '') {
                continue;
            }

            if (($config['email'] ?? false) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = 'Please enter a valid email address.';
            }

            if (isset($config['min']) && is_string($value) && mb_strlen($value) < (int)$config['min']) {
                $errors[$field] = 'Must be at least ' . $config['min'] . ' characters.';
            }

            if (($config['pos'] ?? null) && is_string($value) && !self::isValidPos($value, (string)$config['pos'])) {
                $errors[$field] = 'Enter a valid ' . $config['pos'] . '.';
            }
        }

        return $errors;
    }

    private static function isValidPos(string $value, string $pos): bool
    {
        if ($pos === 'number') {
            return (bool)preg_match('/^[0-9]+$/', $value);
        }

        return (bool)preg_match('/^[A-Za-z\s\'-]{2,}$/', $value);
    }
}
