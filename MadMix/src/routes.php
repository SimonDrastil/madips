<?php
declare(strict_types=1);

use MadMix\Router;
use MadMix\Controller\{HomeController,PlayController,TemplateController,PartyController,AdminController,ApiController,AuthController};

/** @var Router $router */
$router->get('/', [HomeController::class, 'index']);
$router->get('/play', [PlayController::class, 'index']);
$router->get('/play/{slug}', [PlayController::class, 'show']);
$router->get('/play/{slug}/form', [PlayController::class, 'form']);
$router->post('/play/{slug}/generate', [PlayController::class, 'generate']);
$router->post('/play/{slug}/remix', [PlayController::class, 'remix']);
$router->get('/s/{slug}', [PlayController::class, 'shared']);

$router->get('/templates', [TemplateController::class, 'index']);
$router->get('/templates/create', [TemplateController::class, 'create']);
$router->post('/templates', [TemplateController::class, 'store']);
$router->get('/templates/{slug}/edit', [TemplateController::class, 'edit']);
$router->post('/templates/{slug}', [TemplateController::class, 'update']);

$router->get('/party/host', [PartyController::class, 'host']);
$router->get('/party/join', [PartyController::class, 'join']);
$router->get('/party/{code}/lobby', [PartyController::class, 'lobby']);

$router->get('/admin', [AdminController::class, 'dashboard']);

$router->post('/api/preview', [ApiController::class, 'preview']);
$router->post('/api/remix', [ApiController::class, 'remix']);
$router->post('/api/export', [ApiController::class, 'export']);
$router->post('/api/party/submit', [ApiController::class, 'partySubmit']);
$router->get('/api/party/state', [ApiController::class, 'partyState']);

$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'authenticate']);
$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'store']);
$router->post('/logout', [AuthController::class, 'logout']);
