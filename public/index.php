<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . './assets/inc/functions.php';

use app\Controllers\Application;

if (!isset($_SESSION['admin']) && $_SERVER['REQUEST_URI'] !== '/login') {
    $app = new Application();
    $app::redirect('/login');
};

if (isset($_SESSION['admin']) && $_SERVER['REQUEST_URI'] === '/login') {
    $app = new Application();
    $app::redirect('/accounts');
};

$app = new Application();

$response = $app->resolve();
echo $response;
