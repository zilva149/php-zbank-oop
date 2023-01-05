<?php

namespace app\Controllers;

use app\Controllers\Controller;

class SiteController
{
    public function home()
    {
        echo ViewController::renderView('home', [
            'title' => 'Sąskaitų sąrašas',
            'active' => 'home'
        ]);
    }

    public function createAcc()
    {
        echo ViewController::renderView('create-acc', [
            'title' => 'Sukurti sąskaitą',
            'active' => 'create-acc'
        ]);
    }

    public function login()
    {
        echo ViewController::renderView('login', ['title' => 'Prisijungimas']);
    }

    public function addMoney()
    {
        echo ViewController::renderView('add-money', ['title' => 'Pridėti lėšas']);
    }

    public function withdrawMoney()
    {
        echo ViewController::renderView('withdraw-money', ['title' => 'Nuskaičiuoti lėšas']);
    }
}
