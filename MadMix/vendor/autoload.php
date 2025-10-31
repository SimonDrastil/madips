<?php
declare(strict_types=1);

spl_autoload_register(static function (string $class): void {
    $prefix = 'MadMix\\';
    $baseDir = __DIR__ . '/../src/';
    if (str_starts_with($class, $prefix)) {
        $relative = substr($class, strlen($prefix));
        $relativePath = str_replace('\\', '/', $relative);
        $file = $baseDir . $relativePath . '.php';
        if (is_file($file)) {
            require_once $file;
        }
    }
});
