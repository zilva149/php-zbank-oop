<?php

use app\Controllers\Application;

require __DIR__ . '/../vendor/autoload.php';

$root = str_replace('\\', '/', dirname(__DIR__));
$app = new Application($root);

$app->router
    ->get('/', [\app\Controllers\SiteController::class, 'home'])
    ->get('/home', [\app\Controllers\SiteController::class, 'home'])
    ->get('/create-acc', [\app\Controllers\SiteController::class, 'createAcc'])
    ->get('/add-money', [\app\Controllers\SiteController::class, 'addMoney'])
    ->get('/withdraw-money', [\app\Controllers\SiteController::class, 'withdrawMoney'])
    ->get('/login', [\app\Controllers\SiteController::class, 'login']);

$app->resolve();
