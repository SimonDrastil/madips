<?php
declare(strict_types=1);

namespace MadMix\Controller;

use MadMix\Model\Template;
use MadMix\Model\Category;
use MadMix\Util\Csrf;
use MadMix\Util\Sanitizer;
use MadMix\Util\Validator;

final class TemplateController extends BaseController
{
    public function index(): void
    {
        $templates = Template::allPublic();
        $this->view('templates/index', compact('templates'));
    }

    public function create(): void
    {
        $this->requireAuth();
        $categories = Category::all();
        $this->view('templates/create', compact('categories'));
    }

    public function store(): void
    {
        $this->requireAuth();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(422);
            echo 'Invalid token';
            return;
        }

        $inputs = Sanitizer::clean($_POST);
        $errors = Validator::validate($inputs, [
            'title' => ['required' => true, 'min' => 3],
            'body' => ['required' => true],
            'category_id' => ['required' => true],
        ]);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            header('Location: /templates/create');
            return;
        }

        Template::create([
            'user_id' => $_SESSION['user']['id'],
            'category_id' => (int)($inputs['category_id'] ?? 1),
            'title' => $inputs['title'],
            'body' => $inputs['body'],
            'difficulty' => $inputs['difficulty'] ?? 'norm',
            'is_public' => isset($inputs['is_public']) ? 1 : 0,
        ]);

        $_SESSION['flash'] = 'Template created!';
        header('Location: /templates');
    }

    /** @param array<string,string> $params */
    public function edit(array $params): void
    {
        $this->requireAuth();
        $template = Template::findBySlug($params['slug']);
        $categories = Category::all();
        $this->view('templates/edit', compact('template', 'categories'));
    }

    /** @param array<string,string> $params */
    public function update(array $params): void
    {
        $this->requireAuth();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(422);
            echo 'Invalid token';
            return;
        }

        $inputs = Sanitizer::clean($_POST);
        Template::updateBySlug($params['slug'], [
            'title' => $inputs['title'],
            'body' => $inputs['body'],
            'difficulty' => $inputs['difficulty'] ?? 'norm',
            'category_id' => (int)($inputs['category_id'] ?? 1),
            'is_public' => isset($inputs['is_public']) ? 1 : 0,
        ]);

        $_SESSION['flash'] = 'Template updated!';
        header('Location: /templates');
    }
}
