<?php
declare(strict_types=1);

namespace MadMix\Util;

final class RateLimiter
{
    private const LIMIT = 20;
    private const WINDOW = 60; // seconds

    public static function check(string $key): bool
    {
        $now = time();
        $bucket = $_SESSION['_rate_' . $key] ?? ['count' => 0, 'start' => $now];
        if ($now - $bucket['start'] > self::WINDOW) {
            $bucket = ['count' => 0, 'start' => $now];
        }

        if ($bucket['count'] >= self::LIMIT) {
            return false;
        }

        $bucket['count']++;
        $_SESSION['_rate_' . $key] = $bucket;
        return true;
    }
}
