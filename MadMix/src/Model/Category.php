<?php
declare(strict_types=1);

namespace MadMix\Model;

use MadMix\Util\FallbackData;
use RuntimeException;

final class Category
{
    public static function all(): array
    {
        try {
            $stmt = DB::conn()->query('SELECT * FROM categories ORDER BY name');
            return $stmt->fetchAll();
        } catch (RuntimeException $e) {
            return FallbackData::categories();
        }
    }
}
