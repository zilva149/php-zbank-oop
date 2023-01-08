<?php

namespace app\Controllers;

use app\DB\FileReader;
use app\Controllers\Validation;

class Accounts {

    public function index(): string
    {
        $users = Application::$usersFileReader->showAll();
        usort($users, fn ($a, $b) => $a['surname'] <=> $b['surname']);
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

        $_SESSION['name_error'] = '';
        $_SESSION['surname_error'] = '';
        $_SESSION['id_error'] = '';

        if (!Validation::validateName($name)) {
            $_SESSION['name_error'] = 'Nevalidus vardas';
        }

        if (!Validation::validateLength($name, 4)) {
            if($_SESSION['name_error'] === '') {
                $_SESSION['name_error'] = 'Vardas trumpesnis nei 4 raidės';
            }
        }

        if (!Validation::validateSurname($surname)) {
            $_SESSION['surname_error'] = 'Nevalidi pavardė';
        }

        if (!Validation::validateLength($surname, 4)) {
            if($_SESSION['surname_error'] === '') {
                $_SESSION['surname_error'] = 'Pavardė trumpesnė nei 4 raidės';
            }
        }

        if (!Validation::validateID($id)) {
            $_SESSION['id_error'] = 'Nevalidus asmens kodas';
        }

        if (!Validation::validateUniqueID(Application::$usersFileReader->showAll(), $id)) {
            if($_SESSION['id_error'] === '') {
                $_SESSION['id_error'] = 'Asmens kodas jau egzistuoja';
            }
        }

        if($_SESSION['name_error'] !== '' || $_SESSION['surname_error'] !== '' || $_SESSION['id_error'] !== '') {
            $_SESSION['info'] = [
                'name' => $name,
                'surname' => $surname,
                'id' => $id,
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
        unset($_SESSION['name_error']);
        unset($_SESSION['surname_error']);
        unset($_SESSION['id_error']);

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

            if (!Validation::validateSum($_POST['add_amount'])) {
                $_SESSION['modal'] = [
                    'name' => 'error',
                    'modal_message' => 'Prašome įvesti validžią sumą',
                    'modal_color' => '#f01616'
                ];

                return Application::redirect("/add-money/$id");
            }

            $amount = (float) $_POST['add_amount'];

            if (!Validation::validateSumAboveZero($amount)) {
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

            if (!Validation::validateSum($_POST['withdraw_amount'])) {
                $_SESSION['modal'] = [
                    'name' => 'error',
                    'modal_message' => 'Prašome įvesti validžią sumą',
                    'modal_color' => '#f01616'
                ];

                return Application::redirect("/withdraw-money/$id");
            }

            $amount = (float) $_POST['withdraw_amount'];

            if (!Validation::validateWithdrawSum($amount, $user)) {
                $_SESSION['modal'] = [
                    'name' => 'error',
                    'modal_message' => 'Suma viršija turimas lėšas',
                    'modal_color' => '#f01616'
                ];

                return Application::redirect("/withdraw-money/$id");
            }

            if (!Validation::validateSumAboveZero($amount)) {
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
        if (Validation::validateDeleteUser($user)) {
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