<?php
declare(strict_types=1);

namespace MadMix;

use MadMix\Controller\ApiController;
use MadMix\Controller\AuthController;
use MadMix\Controller\HomeController;
use MadMix\Controller\PlayController;
use MadMix\Controller\TemplateController;
use MadMix\Controller\PartyController;
use MadMix\Controller\AdminController;
use MadMix\Util\Response;

/**
 * Extremely small router that supports dynamic segments using {slug} placeholders.
 */
class Router
{
    /** @var array<string, array<int, array{pattern:string, handler:array, methods:array<string,bool>}>> */
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, array $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, array $handler): void
    {
        $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_-]*)\}#', '(?P<$1>[a-zA-Z0-9_-]+)', $path);
        $pattern = '#^' . rtrim($pattern, '/') . '$#';
        $this->routes[$path][] = [
            'pattern' => $pattern,
            'handler' => $handler,
            'methods' => [$method => true],
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        foreach ($this->routes as $path => $definitions) {
            foreach ($definitions as $route) {
                if (!isset($route['methods'][$method])) {
                    continue;
                }

                if (preg_match($route['pattern'], rtrim($uri, '/'), $matches)) {
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    [$controller, $action] = $route['handler'];
                    $controllerInstance = $this->resolveController($controller);
                    $controllerInstance->$action($params);
                    return;
                }
            }
        }

        Response::status(404);
        echo 'Page not found';
    }

    private function resolveController(string $controller): object
    {
        return match ($controller) {
            HomeController::class => new HomeController(),
            PlayController::class => new PlayController(),
            TemplateController::class => new TemplateController(),
            PartyController::class => new PartyController(),
            AdminController::class => new AdminController(),
            ApiController::class => new ApiController(),
            AuthController::class => new AuthController(),
            default => new $controller(),
        };
    }
}
