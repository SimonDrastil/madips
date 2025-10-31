<?php
declare(strict_types=1);

namespace MadMix\Model;

final class Category
{
    public static function all(): array
    {
        $stmt = DB::conn()->query('SELECT * FROM categories ORDER BY name');
        return $stmt->fetchAll();
    }
}
