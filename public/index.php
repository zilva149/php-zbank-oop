<?php

use app\Controllers\Application;

require __DIR__ . '/../vendor/autoload.php';

$root = str_replace('\\', '/', dirname(__DIR__));
$app = new Application($root);

$app->router
    ->get('/', [\app\Controllers\SiteController::class, 'home'])
    ->get('/home', [\app\Controllers\SiteController::class, 'home'])
    ->get('/contacts', [\app\Controllers\SiteController::class, 'contacts'])
    ->get('/login', [\app\Controllers\AuthController::class, 'login']);

$app->resolve();
