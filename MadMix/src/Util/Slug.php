<?php
declare(strict_types=1);

namespace MadMix\Util;

final class Slug
{
    public static function make(string $value): string
    {
        $slug = strtolower(trim($value));
        $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug) ?? '';
        return trim($slug, '-') ?: bin2hex(random_bytes(4));
    }
}
