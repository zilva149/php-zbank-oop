<?php

namespace app\Controllers;

use app\Controllers\Application;

class Controller
{
    public function renderView(string $layout, string $page, array $params = [])
    {
        $layoutContent = $this->getLayoutContent($layout);
        $pageContent = $this->getPageContent($page, $params);
        $content = str_replace('{{content}}', $pageContent, $layoutContent);

        echo $content;
    }

    public function getLayoutContent(string $layout)
    {
        ob_start();
        require Application::$root . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    public function getPageContent(string $page, array $params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        require Application::$root . "/views/pages/$page.php";
        return ob_get_clean();
    }
}
