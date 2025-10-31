<?php
declare(strict_types=1);

namespace MadMix\Controller;

final class BaseController
{
    protected function view(string $path, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $viewPath = __DIR__ . '/../View/' . $path . '.php';
        $layout = __DIR__ . '/../View/layout/base.php';
        if (!is_file($viewPath)) {
            http_response_code(404);
            echo 'View not found';
            return;
        }

        require $layout;
    }

    protected function isAuthenticated(): bool
    {
        return isset($_SESSION['user']);
    }

    protected function requireAuth(): void
    {
        if (!$this->isAuthenticated()) {
            header('Location: /login');
            exit;
        }
    }

    protected function requireAdmin(): void
    {
        $this->requireAuth();
        if (($_SESSION['user']['role'] ?? 'user') !== 'admin') {
            http_response_code(403);
            echo 'Forbidden';
            exit;
        }
    }
}
