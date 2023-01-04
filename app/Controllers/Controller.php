<?php

namespace app\Controllers;

use app\Controllers\Application;

class Controller
{
    public function renderView(string $page, array $params = [])
    {
        ob_start();
        extract($params);
        require Application::$root . './views/layouts/header.php';
        require Application::$root . "./views/pages/$page.php";
        require Application::$root . './views/layouts/footer.php';
        return ob_get_clean();
    }
}
