<?php
declare(strict_types=1);

namespace MadMix\Controller;

use MadMix\Model\Template;
use MadMix\Model\Story;
use MadMix\Util\Csrf;
use MadMix\Util\TextEngine;
use MadMix\Util\Validator;
use MadMix\Util\Sanitizer;
use MadMix\Util\RateLimiter;

final class PlayController extends BaseController
{
    private TextEngine $engine;

    public function __construct()
    {
        $this->engine = new TextEngine();
    }

    public function index(): void
    {
        $templates = Template::allPublic();
        $this->view('play/index', compact('templates'));
    }

    /** @param array<string,string> $params */
    public function show(array $params): void
    {
        $template = Template::findBySlug($params['slug']);
        if (!$template) {
            http_response_code(404);
            echo 'Template not found';
            return;
        }

        $placeholders = $this->engine->placeholders($template['body']);
        $this->view('play/form', compact('template', 'placeholders'));
    }

    /** @param array<string,string> $params */
    public function form(array $params): void
    {
        $this->show($params);
    }

    /** @param array<string,string> $params */
    public function generate(array $params): void
    {
        $template = Template::findBySlug($params['slug']);
        if (!$template) {
            http_response_code(404);
            echo 'Template not found';
            return;
        }

        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(422);
            echo 'Invalid token';
            return;
        }

        if (!RateLimiter::check('play_generate')) {
            http_response_code(429);
            echo 'Slow down';
            return;
        }

        $inputs = Sanitizer::clean($_POST);
        $placeholders = $this->engine->placeholders($template['body']);
        $rules = [];
        foreach ($placeholders as $key => $pos) {
            $rules[$key] = ['required' => true, 'pos' => $pos];
        }
        $errors = Validator::validate($inputs, $rules);
        $render = $this->engine->render($template['body'], $inputs, true);
        $errors = array_merge($errors, $render['errors']);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $inputs;
            header('Location: /play/' . $template['slug'] . '/form');
            return;
        }

        $shareSlug = Story::create((int)$template['id'], $_SESSION['user']['id'] ?? null, $render['content']);
        $_SESSION['flash'] = 'Story saved!';
        $this->view('play/result', [
            'template' => $template,
            'content' => $render['content'],
            'shareSlug' => $shareSlug,
        ]);
    }

    /** @param array<string,string> $params */
    public function remix(array $params): void
    {
        $template = Template::findBySlug($params['slug']);
        if (!$template) {
            http_response_code(404);
            echo 'Template not found';
            return;
        }

        $inputs = Sanitizer::clean($_POST);
        $render = $this->engine->render($template['body'], $inputs, false);
        $this->view('play/result', [
            'template' => $template,
            'content' => $render['content'],
            'shareSlug' => null,
        ]);
    }

    /** @param array<string,string> $params */
    public function shared(array $params): void
    {
        $story = Story::findByShareSlug($params['slug']);
        if (!$story) {
            http_response_code(404);
            echo 'Story not found';
            return;
        }

        $template = ['title' => 'Shared Story'];
        $this->view('play/result', [
            'template' => $template,
            'content' => $story['content'],
            'shareSlug' => $story['share_slug'],
        ]);
    }
}
