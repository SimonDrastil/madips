<?php
declare(strict_types=1);

namespace MadMix\Util;

final class Sanitizer
{
    /**
     * @param array<string,mixed> $input
     * @return array<string,string>
     */
    public static function clean(array $input): array
    {
        $sanitized = [];
        foreach ($input as $key => $value) {
            if (is_string($value)) {
                $sanitized[$key] = trim($value);
            }
        }

        return $sanitized;
    }
}
