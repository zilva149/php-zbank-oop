<?php

namespace app\Controllers;

use app\DB\FileReader;
use app\Models\AccountModel;

class Accounts {

    public function index(): string
    {
        $users = Application::$usersFileReader->showAll();
        $pageTitle = 'Sąskaitų sąrašas';
        $active = 'accounts';
        return Application::renderView('accounts', compact('users' ,'pageTitle', 'active'));
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
        $name = $_POST['name'] ?? '';
        $surname = $_POST['surname'] ?? '';
        $id = $_POST['id'] ?? '';
        $iban = $_POST['iban'] ?? '';

        if (!preg_match('/^[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]+([\s]?[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]+|[\']?[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]*)$/', $name)) {
            $_SESSION['modal_sm'] = [
                'name' => 'error',
                'modal_place' => 'name',
                'modal_message' => 'Nevalidus vardas',
                'modal_color' => '#f01616',
            ];
            return Application::redirect('/create-account');
        }

        if (strlen($name) < 4) {
            $_SESSION['modal_sm'] = [
                'name' => 'error',
                'modal_place' => 'name',
                'modal_message' => 'Vardas turi būti mažiausiai 4-ių raidžių ilgio',
                'modal_color' => '#f01616',
            ];
            return Application::redirect('/create-account');
        }

        if (!preg_match('/^[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]+([\s]?[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]+|[\']?[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]*)$/', $surname)) {
            $_SESSION['modal_sm'] = [
                'name' => 'error',
                'modal_place' => 'surname',
                'modal_message' => 'Nevalidi pavardė',
                'modal_color' => '#f01616',
            ];
            return Application::redirect('/create-account');
        }

        if (strlen($surname) < 4) {
            $_SESSION['modal_sm'] = [
                'name' => 'error',
                'modal_place' => 'name',
                'modal_message' => 'Pavardė turi būti mažiausiai 4-ių raidžių ilgio',
                'modal_color' => '#f01616',
            ];
            return Application::redirect('/create-account');
        }

        if (!preg_match('/^[1-6]\d{2}(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01])\d{4}$/', $id)) {
            $_SESSION['modal_sm'] = [
                'name' => 'error',
                'modal_place' => 'id',
                'modal_message' => 'Nevalidus asmens kodas',
                'modal_color' => '#f01616',
            ];
            return Application::redirect('/create-account');
        }

        if (!validateIDNum(Application::$usersFileReader->showAll(), $id)) {
            $_SESSION['modal_sm'] = [
                'name' => 'error',
                'modal_place' => 'id',
                'modal_message' => 'Asmens kodas jau egzistuoja',
                'modal_color' => '#f01616',
            ];
            return Application::redirect('/create-account');
        }

        $user = [
            'name' => $name,
            'surname' => $surname,
            'bank_acc' => $iban,
            'id_num' => $id,
            'money' => 0
        ];

        $_SESSION['modal'] = [
            'name' => 'success',
            'modal_message' => 'Naujas klientas sėkmingai pridėtas',
            'modal_color' => '#35bd0f',
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

            if (preg_match('/^-?(?:[0-9]*[.])?[0-9]+$/', $_POST['add_amount'])) {
                $amount = (float) $_POST['add_amount'];
            } else {
                $_SESSION['modal'] = [
                    'name' => 'error',
                    'modal_message' => 'Prašome įvesti validžią sumą',
                    'modal_color' => '#f01616'
                ];

                return Application::redirect("/add-money/$id");
            }

            if ($amount <= 0) {
                $_SESSION['modal'] = [
                    'name' => 'error',
                    'modal_message' => 'Negalima pridėti nulinės arba negatyvios sumos',
                    'modal_color' => '#f01616'
                ];

                return Application::redirect("/add-money/$id");
            }

            $user['money'] = round($user['money'] + $amount, 2);
            Application::$usersFileReader->update($id, $user);

            $_SESSION['modal'] = [
                'name' => 'success',
                'modal_message' => 'Sėkmingai pridėta lėšų',
                'modal_color' => '#35bd0f'
            ];
            return Application::redirect('/accounts');
        }

        if(isset($_POST['withdraw_amount'])) {
            $user = Application::$usersFileReader->show($id);

            if (preg_match('/^-?(?:[0-9]*[.])?[0-9]+$/', $_POST['withdraw_amount'])) {
                $amount = (float) $_POST['withdraw_amount'];
            } else {
                $_SESSION['modal'] = [
                    'name' => 'error',
                    'modal_message' => 'Prašome įvesti validžią sumą',
                    'modal_color' => '#f01616'
                ];

                return Application::redirect("/withdraw-money/$id");
            }

            if ($amount > $user['money']) {
                $_SESSION['modal'] = [
                    'name' => 'error',
                    'modal_message' => 'Suma viršija turimas lėšas',
                    'modal_color' => '#f01616'
                ];

                return Application::redirect("/withdraw-money/$id");
            }

            if ($amount <= 0) {
                $_SESSION['modal'] = [
                    'name' => 'error',
                    'modal_message' => 'Negalima nuskaičiuoti nulinės arba negatyvios sumos',
                    'modal_color' => '#f01616'
                ];

                return Application::redirect("/withdraw-money/$id");
            }

            $user['money'] = round($user['money'] - $amount, 2);
            Application::$usersFileReader->update($id, $user);

            $_SESSION['modal'] = [
                'name' => 'success',
                'modal_message' => 'Sėkmingai nuskaičiuotos lėšos',
                'modal_color' => '#35bd0f'
            ];
            return Application::redirect('/accounts');
        }
    }

    public function delete($id)
    {
        $user = Application::$usersFileReader->show($id);
        if ($user['money'] == 0) {
            Application::$usersFileReader->delete($id);

            $_SESSION['modal'] = [
                'name' => 'success',
                'modal_message' => 'Sąskaita sėkmingai ištrinta',
                'modal_color' => '#35bd0f'
            ];

            return Application::redirect('/accounts');
        } else {
            $_SESSION['modal'] = [
                'name' => 'error',
                'modal_message' => 'Sąskaitos, kurioje yra pinigų, negalima ištrinti',
                'modal_color' => '#f01616'
            ];

            return Application::redirect("/accounts");
        }
    }

    public function error(): string
    {
        $pageTitle = '404';
        return Application::renderView('error', compact('pageTitle'));
    }
}