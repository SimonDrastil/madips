<?php
declare(strict_types=1);

namespace MadMix\Controller;

use MadMix\Model\User;
use MadMix\Util\Csrf;
use MadMix\Util\Sanitizer;
use MadMix\Util\Validator;
use MadMix\Util\Response;

final class AuthController extends BaseController
{
    public function login(): void
    {
        $this->view('auth/login');
    }

    public function authenticate(): void
    {
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(422);
            echo 'Invalid token';
            return;
        }

        $inputs = Sanitizer::clean($_POST);
        $user = User::findByEmail($inputs['email']);
        if (!$user || !password_verify($inputs['password'], $user['password_hash'])) {
            $_SESSION['errors'] = ['email' => 'Invalid credentials'];
            header('Location: /login');
            return;
        }

        $_SESSION['user'] = $user;
        Response::redirect('/');
    }

    public function register(): void
    {
        $this->view('auth/register');
    }

    public function store(): void
    {
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(422);
            echo 'Invalid token';
            return;
        }

        $inputs = Sanitizer::clean($_POST);
        $errors = Validator::validate($inputs, [
            'email' => ['required' => true, 'email' => true],
            'password' => ['required' => true, 'min' => 6],
        ]);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            header('Location: /register');
            return;
        }

        $inputs['role'] = 'user';
        User::create($inputs);
        $_SESSION['flash'] = 'Welcome to MadMix!';
        Response::redirect('/login');
    }

    public function logout(): void
    {
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(422);
            echo 'Invalid token';
            return;
        }

        session_destroy();
        Response::redirect('/');
    }
}
