<?php

namespace app\Controllers;

use app\DB\FileReader;

class Application
{
    public static Application $app;
    public static Accounts $accounts;
    public static AuthController $authController;
    public static FileReader $usersFileReader;
    public static FileReader $adminsFileReader;

    public function __construct()
    {
        self::$app = $this;
        self::$accounts = new Accounts();
        self::$authController = new AuthController();
        self::$usersFileReader = new FileReader('users');
        self::$adminsFileReader = new FileReader('admins');
    }

    public function resolve()
    {
        $url = explode('/', $_SERVER['REQUEST_URI']);
        array_shift($url);
        return self::router($url);
    }

    private static function router(array $url)
    {
        $method = self::$app->getMethod();

        if ($method == 'OPTIONS') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: OPTIONS, GET, POST, DELETE, PUT');
            header("Access-Control-Allow-Headers: Authorization, Content-Type, X-Requested-With");
            header('Content-Type: application/json');
            return null;
        }

        if (!$url[0] && count($url) === 1 && $method === 'GET') {
            return self::$accounts->index();
        }

        if ($url[0] === 'accounts' && count($url) === 1 && $method === 'GET') {
            return self::$accounts->index();
        }

        if ($url[0] === 'accounts' && $url[1] === 'usd' && count($url) === 2 && $method === 'GET') {
            return self::$accounts->indexUSD();
        }

        if ($url[0] === 'accounts' && $url[1] === 'gbp' && count($url) === 2 && $method === 'GET') {
            return self::$accounts->indexGBP();
        }

        if ($url[0] === 'login' && count($url) === 1 && $method === 'GET') {
            return self::$authController->login();
        }

        if ($url[0] === 'login' && count($url) === 1 && $method === 'POST') {
            return self::$authController->login();
        }

        if ($url[0] === 'accounts' && $url[1] === 'logout' && count($url) === 2 && $method === 'GET') {
            return self::$authController->logout();
        }

        if ($url[0] === 'create-account' && count($url) === 1 && $method === 'GET') {
            return self::$accounts->create();
        }

        if ($url[0] === 'create-account' && $url[1] === 'save' && count($url) == 2 && $method == 'POST') {
            return self::$accounts->save();
        }

        if ($url[0] === 'add-money' && preg_match('/^\d+$/',$url[1]) && count($url) == 2 && $method == 'GET') {
            return self::$accounts->add($url[1]);
        }

        if ($url[0] === 'withdraw-money' && preg_match('/^\d+$/',$url[1]) && count($url) == 2 && $method == 'GET') {
            return self::$accounts->withdraw($url[1]);
        }

        if (($url[0] === 'add-money' || $url[0] === 'withdraw-money') && $url[1] == 'update' && preg_match('/^\d+$/',$url[2]) && count($url) == 3 && $method == 'POST') {
            return self::$accounts->update($url[2]);
        }

        if ($url[0] === 'delete' && preg_match('/^\d+$/',$url[1]) && count($url) == 2 && $method == 'POST') {
            return self::$accounts->delete($url[1]);
        }


        return self::$accounts->error();
    }

    public static function renderView(string $page, array $params = []): string
    {
        ob_start();
        extract($params);
        require './../views/layouts/header.php';
        require "./../views/pages/$page.php";
        return ob_get_clean();
    }

    public static function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function redirect($url)
    {
        header('Location: ' . $url);
        return null;
    }
}
