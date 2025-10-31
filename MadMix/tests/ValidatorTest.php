<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use MadMix\Util\Validator;

$errors = Validator::validate([
    'email' => 'not-email',
    'name' => '',
], [
    'email' => ['required' => true, 'email' => true],
    'name' => ['required' => true],
]);
assert(isset($errors['email']));
assert(isset($errors['name']));

echo "Validator tests passed\n";
