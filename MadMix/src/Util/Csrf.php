<?php
declare(strict_types=1);

namespace MadMix\Util;

final class Csrf
{
    private const TOKEN_KEY = '_csrf_token';

    public static function token(): string
    {
        if (!isset($_SESSION[self::TOKEN_KEY])) {
            $_SESSION[self::TOKEN_KEY] = bin2hex(random_bytes(32));
        }

        return $_SESSION[self::TOKEN_KEY];
    }

    public static function field(): string
    {
        $token = self::token();
        return '<input type="hidden" name="_token" value="' . htmlspecialchars($token) . '">';
    }

    public static function validate(string $token): bool
    {
        return hash_equals($_SESSION[self::TOKEN_KEY] ?? '', $token);
    }
}
