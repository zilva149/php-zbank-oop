<?php

namespace app\Controllers;

use app\DB\FileReader;
use app\Controllers\Validation;
use app\Controllers\CurrencyAPI;

class Accounts {

    public function index(): string
    {
        $users = Application::$usersFileReader->showAll();
        usort($users, fn ($a, $b) => $a['surname'] <=> $b['surname']);
        $pageTitle = 'Sąskaitų sąrašas';
        $active = 'accounts';
        $current = 'eur';
        return Application::renderView('accounts', compact('users' ,'pageTitle', 'active', 'current'));
    }

    public function indexUSD(): string
    {
        $users = Application::$usersFileReader->showAll();
        usort($users, fn ($a, $b) => $a['surname'] <=> $b['surname']);

        $response = CurrencyAPI::getCurrencyRate('USD');

        foreach ($users as &$user) {
            $user['money'] *= $response['rates']['USD'];
        }

        $pageTitle = 'Sąskaitų sąrašas';
        $active = 'accounts';
        $current = 'usd';
        return Application::renderView('accounts', compact('users' ,'pageTitle', 'active', 'current'));
    }

    public function indexGBP(): string
    {
        $users = Application::$usersFileReader->showAll();
        usort($users, fn ($a, $b) => $a['surname'] <=> $b['surname']);

        $response = CurrencyAPI::getCurrencyRate('GBP');

        foreach ($users as &$user) {
            $user['money'] *= $response['rates']['GBP'];
        }

        $pageTitle = 'Sąskaitų sąrašas';
        $active = 'accounts';
        $current = 'gbp';
        return Application::renderView('accounts', compact('users' ,'pageTitle', 'active', 'current'));
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

        if (!Validation::validateName($name)) {
            $_SESSION['name_error'] = 'Nevalidus vardas';
        }

        if (!Validation::validateLength($name, 4)) {
            if(!isset($_SESSION['name_error'])) {
                $_SESSION['name_error'] = 'Vardas trumpesnis nei 4 raidės';
            }
        }

        if (!Validation::validateSurname($surname)) {
            $_SESSION['surname_error'] = 'Nevalidi pavardė';
        }

        if (!Validation::validateLength($surname, 4)) {
            if(!isset($_SESSION['surname_error'])) {
                $_SESSION['surname_error'] = 'Pavardė trumpesnė nei 4 raidės';
            }
        }

        if (!Validation::validateID($id)) {
            $_SESSION['id_error'] = 'Nevalidus asmens kodas';
        }

        if (!Validation::validateUniqueID(Application::$usersFileReader->showAll(), $id)) {
            if(!isset($_SESSION['id_error'])) {
                $_SESSION['id_error'] = 'Asmens kodas jau egzistuoja';
            }
        }

        if(isset($_SESSION['name_error']) || isset($_SESSION['surname_error']) || isset($_SESSION['id_error'])) {
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
        Application::$usersFileReader->create($user);

        $_SESSION['modal'] = [
            'operation' => 'success',
            'message' => 'Naujas klientas sėkmingai pridėtas'
        ];
        return Application::redirect('/accounts');
    }

    public function add($id): string
    {
        $user = Application::$usersFileReader->show($id);

        if(!$user) {
            return $this->error();
        }

        $pageTitle = 'Pridėti lėšas';
        return Application::renderView('add-money', compact('pageTitle', 'user'));
    }

    public function withdraw($id): string
    {
        $user = Application::$usersFileReader->show($id);

        if(!$user) {
            return $this->error();
        }

        $pageTitle = 'Nuskaičiuoti lėšas';
        return Application::renderView('withdraw-money', compact('pageTitle', 'user'));
    }

    public function update($id)
    {
        if(isset($_POST['add_amount'])) {
            $user = Application::$usersFileReader->show($id);

            if (!Validation::validateSum($_POST['add_amount'])) {
                $_SESSION['modal'] = [
                    'operation' => 'error',
                    'message' => 'Prašome įvesti validžią sumą'
                ];

                return Application::redirect("/add-money/$id");
            }

            $amount = (float) $_POST['add_amount'];

            if (!Validation::validateSumAboveZero($amount)) {
                $_SESSION['modal'] = [
                    'operation' => 'error',
                    'message' => 'Negalima pridėti nulinės arba negatyvios sumos'
                ];

                return Application::redirect("/add-money/$id");
            }

            $user['money'] = round($user['money'] + $amount, 2);
            Application::$usersFileReader->update($id, $user);

            $_SESSION['modal'] = [
                'operation' => 'success',
                'message' => 'Sėkmingai pridėta lėšų'
            ];
            return Application::redirect('/accounts');
        }

        if(isset($_POST['withdraw_amount'])) {
            $user = Application::$usersFileReader->show($id);

            if (!Validation::validateSum($_POST['withdraw_amount'])) {
                $_SESSION['modal'] = [
                    'operation' => 'error',
                    'message' => 'Prašome įvesti validžią sumą'
                ];

                return Application::redirect("/withdraw-money/$id");
            }

            $amount = (float) $_POST['withdraw_amount'];

            if (!Validation::validateWithdrawSum($amount, $user)) {
                $_SESSION['modal'] = [
                    'operation' => 'error',
                    'message' => 'Suma viršija turimas lėšas'
                ];

                return Application::redirect("/withdraw-money/$id");
            }

            if (!Validation::validateSumAboveZero($amount)) {
                $_SESSION['modal'] = [
                    'operation' => 'error',
                    'message' => 'Negalima nuskaičiuoti nulinės arba negatyvios sumos'
                ];

                return Application::redirect("/withdraw-money/$id");
            }

            $user['money'] = round($user['money'] - $amount, 2);
            Application::$usersFileReader->update($id, $user);

            $_SESSION['modal'] = [
                'operation' => 'success',
                'message' => 'Sėkmingai nuskaičiuotos lėšos'
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
                'operation' => 'success',
                'message' => 'Sąskaita sėkmingai ištrinta'
            ];

            return Application::redirect('/accounts');
        } else {
            $_SESSION['modal'] = [
                'operation' => 'error',
                'message' => 'Sąskaitos, kurioje yra pinigų, negalima ištrinti'
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