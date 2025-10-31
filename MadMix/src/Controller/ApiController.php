<?php
declare(strict_types=1);

namespace MadMix\Controller;

use MadMix\Util\Response;
use MadMix\Util\TextEngine;
use MadMix\Util\Sanitizer;
use MadMix\Util\Exporter;
use MadMix\Util\RateLimiter;
use MadMix\Model\Party;
use MadMix\Util\Validator;
use MadMix\Model\WordBank;

final class ApiController
{
    private TextEngine $engine;

    public function __construct()
    {
        $this->engine = new TextEngine();
    }

    public function preview(): void
    {
        if (!RateLimiter::check('api_preview')) {
            Response::json(['error' => 'Too many requests'], 429);
            return;
        }
        $inputs = Sanitizer::clean($_POST);
        $templateBody = $inputs['template'] ?? '';
        $render = $this->engine->render($templateBody, $inputs, true);
        Response::json($render);
    }

    public function remix(): void
    {
        $inputs = Sanitizer::clean($_POST);
        if (!empty($inputs['pos'])) {
            $record = WordBank::randomByPos($inputs['pos']);
            Response::json(['word' => $record['word'] ?? null]);
            return;
        }
        $templateBody = $inputs['template'] ?? '';
        $render = $this->engine->render($templateBody, $inputs, false);
        Response::json($render);
    }

    public function export(): void
    {
        $inputs = Sanitizer::clean($_POST);
        $format = $inputs['format'] ?? 'png';
        $title = $inputs['title'] ?? 'MadMix Story';
        $body = $inputs['body'] ?? '';
        if ($format === 'pdf') {
            $pdf = Exporter::pdf($title, $body);
            header('Content-Type: application/pdf');
            echo $pdf;
        } else {
            $png = Exporter::png($title, $body);
            header('Content-Type: image/png');
            echo $png;
        }
    }

    public function partySubmit(): void
    {
        $inputs = Sanitizer::clean($_POST);
        $errors = Validator::validate($inputs, [
            'code' => ['required' => true],
            'placeholder_key' => ['required' => true],
            'value' => ['required' => true],
            'nick' => ['required' => true],
        ]);
        if ($errors) {
            Response::json(['errors' => $errors], 422);
            return;
        }

        $room = Party::findByCode($inputs['code']);
        if (!$room) {
            Response::json(['error' => 'Room not found'], 404);
            return;
        }

        Party::submit((int)$room['id'], $inputs['placeholder_key'], $inputs['value'], $inputs['nick']);
        Response::json(['status' => 'ok']);
    }

    public function partyState(): void
    {
        $code = $_GET['code'] ?? '';
        $state = Party::stateByCode($code);
        Response::json($state);
    }
}
