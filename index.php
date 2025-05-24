<?php

require __DIR__ . '/vendor/autoload.php';

use App\Core\Engine;

$engine = new Engine();

$engine->run([
    'user' => ['type' => 'VIP'],
    'order' => ['total' => 600000],
]);