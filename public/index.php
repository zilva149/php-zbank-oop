<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . './assets/inc/functions.php';

use app\Controllers\Application;

$app = new Application();

if (!isset($_SESSION['admin']) && $_SERVER['REQUEST_URI'] !== '/login') {
    $app::redirect('/login');
};

if (isset($_SESSION['admin']) && $_SERVER['REQUEST_URI'] === '/login') {
    $app::redirect('/accounts');
};

$response = $app->resolve();
echo $response;
