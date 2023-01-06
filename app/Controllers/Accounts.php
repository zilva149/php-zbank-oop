<?php

namespace app\Controllers;

use app\DB\FileReader;

class Accounts {

    public function login(): string
    {
        $pageTitle = 'Prisijungimas';
        return Application::renderView('login', compact( 'pageTitle'));
    }

    public function logout(): string
    {
        $pageTitle = 'Prisijungimas';
        return Application::renderView('login', compact( 'pageTitle'));
    }

    public function index(): string
    {
        $users = Application::$usersFileReader->showAll();
        $pageTitle = 'Sąskaitų sąrašas';
        $active = 'index';
        return Application::renderView('index', compact('users' ,'pageTitle', 'active'));
    }

    public function create(): string
    {
        $users = Application::$usersFileReader->showAll();
        $pageTitle = 'Nauja sąskaita';
        $active = 'create-account';
        return Application::renderView( 'create-acc', compact('users', 'pageTitle', 'active'));
    }

    public function save()
    {
        $user = [
            'name' => $_POST['name'],
            'surname' => $_POST['surname'],
            'bank_acc' => $_POST['iban'],
            'id_num' => $_POST['id'],
            'money' => 0
        ];
        Application::$usersFileReader->create($user);
        return Application::redirect('/accounts');
    }

    public function add($id): string
    {
        $user = Application::$usersFileReader->show($id);
        $pageTitle = 'Pridėti lėšas';
        return Application::renderView('add-money', compact('pageTitle', 'user'));
    }

    public function withdraw($id): string
    {
        $user = Application::$usersFileReader->show($id);
        $pageTitle = 'Nuskaičiuoti lėšas';
        return Application::renderView('withdraw-money', compact('pageTitle', 'user'));
    }

    public function update($id)
    {
        if(isset($_POST['add_amount'])) {
            $user = Application::$usersFileReader->show($id);

            if (preg_match('/^(?:[0-9]*[.])?[0-9]+$/', $_POST['add_amount'])) {
                $amount = (float) $_POST['add_amount'];
            } else {
                return 'Nevalidi summa';
            }

            if ($amount > 0) {
                $user['money'] = round($user['money'] + $amount, 2);

                Application::$usersFileReader->update($id, $user);
                return Application::redirect('/accounts');
            } else {
                return 'Negalima pridėti nulinės';
            }
        }

        if(isset($_POST['withdraw_amount'])) {
            $user = Application::$usersFileReader->show($id);

            if (preg_match('/^(?:[0-9]*[.])?[0-9]+$/', $_POST['withdraw_amount'])) {
                $amount = (float) $_POST['withdraw_amount'];
            } else {
                return 'Nevalidi suma';
            }

            if ($amount > $user['money']) {
                return 'Suma viršija turimas lėšas';
            } else if ($amount > 0) {
                $user['money'] = round($user['money'] - $amount, 2);

                Application::$usersFileReader->update($id, $user);
                return Application::redirect('/accounts');
            } else {
                return 'Negalima nuskaičiuoti nulinės';
            }
        }
    }

    public function delete($id)
    {
        $user = Application::$usersFileReader->show($id);
        if ($user['money'] == 0) {
            Application::$usersFileReader->delete($id);
            return Application::redirect('/accounts');
        } else {
            return 'Negalima ištrinti sąskaitos, kurioje yra lėšų';
        }
    }

    public function error(): string
    {
        $pageTitle = '404';
        return Application::renderView('error', compact('pageTitle'));
    }
}