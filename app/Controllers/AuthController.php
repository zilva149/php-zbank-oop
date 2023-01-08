<?php

namespace app\Controllers;

class AuthController
{
    public function login()
    {
        if(Application::getMethod() === 'GET'){
            $pageTitle = 'Prisijungimas';
            return Application::renderView('login', compact('pageTitle'));
        }

        if(Application::getMethod() === 'POST'){
            $admins = Application::$adminsFileReader->showAll();
            $email = $_POST['email'] ?? '';
            $pass = md5($_POST['pass']) ?? '';

            foreach ($admins as $admin) {
                if ($admin['email'] == $email && $admin['psw'] == $pass) {
                    $_SESSION['admin'] = $admin['name'];
                    return Application::redirect('/accounts');
                }
            }

            $_SESSION['login_error'] = 'Neteisingas el. paštas arba slaptažodis';

            return Application::redirect('/login');
        }
    }

    public function logout()
    {
            session_unset();
            session_destroy();
            return Application::redirect('/login');
    }
}
