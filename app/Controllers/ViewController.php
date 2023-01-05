<?php

namespace app\Controllers;

use app\Controllers\Application;

class ViewController
{
    public static function renderView(string $page, array $params = [])
    {
        ob_start();
        extract($params);
        require Application::$root . '/views/layouts/header.php';
        require Application::$root . "/views/pages/$page.php";
        return ob_get_clean();
    }
}
