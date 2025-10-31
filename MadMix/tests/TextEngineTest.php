<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use MadMix\Util\TextEngine;

$engine = new TextEngine();
$template = 'The {adjective} {noun} will {verb}.';
$result = $engine->render($template, [
    'adjective' => 'brave',
    'noun' => 'astronaut',
    'verb' => 'sing',
]);
assert($result['content'] === 'The brave astronaut will sing.');
assert(empty($result['errors']));

$template = '{set:hero={name}} {hero|title} saved the day with a {adjective|upper} shout.';
$result = $engine->render($template, [
    'name' => 'nova',
    'adjective' => 'mighty',
]);
assert(str_contains($result['content'], 'Nova'));
assert(str_contains($result['content'], 'MIGHTY'));

$template = 'Flip a {choice|coin|switch} now.';
$result = $engine->render($template, []);
assert(str_starts_with($result['content'], 'Flip a '));

echo "TextEngine tests passed\n";
