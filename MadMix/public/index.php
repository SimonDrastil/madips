<?php
declare(strict_types=1);

use MadMix\Router;
use MadMix\Util\Config;

require_once __DIR__ . '/../vendor/autoload.php';

session_start([
    'cookie_httponly' => true,
    'cookie_samesite' => 'Strict',
]);

Config::load(__DIR__ . '/../.env');

$router = new Router();
require_once __DIR__ . '/../src/routes.php';

$router->dispatch($_SERVER['REQUEST_METHOD'], strtok($_SERVER['REQUEST_URI'], '?'));
