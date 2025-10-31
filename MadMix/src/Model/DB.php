<?php
declare(strict_types=1);

namespace MadMix\Model;

use MadMix\Util\Config;
use PDO;
use PDOException;
use RuntimeException;

final class DB
{
    private static ?PDO $pdo = null;
    private static ?string $error = null;

    public static function conn(): PDO
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        if (self::$error !== null) {
            throw new RuntimeException(self::$error);
        }

        try {
            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', Config::get('DB_HOST', '127.0.0.1'), Config::get('DB_NAME', 'madmix'));
            self::$pdo = new PDO($dsn, Config::get('DB_USER', 'root'), Config::get('DB_PASS', ''), [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            self::$error = 'Database connection failed: ' . $e->getMessage();
            throw new RuntimeException(self::$error);
        }

        return self::$pdo;
    }

    public static function isAvailable(): bool
    {
        if (self::$pdo !== null) {
            return true;
        }

        if (self::$error !== null) {
            return false;
        }

        try {
            self::conn();
            return true;
        } catch (RuntimeException) {
            return false;
        }
    }

    public static function lastError(): ?string
    {
        return self::$error;
    }
}
