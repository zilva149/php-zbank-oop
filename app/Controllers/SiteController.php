<?php

namespace app\Controllers;

use app\Controllers\Controller;

class SiteController extends Controller
{
    public function home()
    {
        echo $this->renderView('home', [
            'title' => 'Sąskaitų sąrašas',
            'active' => 'home'
        ]);
    }

    public function createAcc()
    {
        echo $this->renderView('create-acc', [
            'title' => 'Sukurti sąskaitą',
            'active' => 'create-acc'
        ]);
    }

    public function login()
    {
        echo $this->renderView('login', ['title' => 'Prisijungimas']);
    }

    public function addMoney()
    {
        echo $this->renderView('add-money', ['title' => 'Pridėti lėšas']);
    }

    public function withdrawMoney()
    {
        echo $this->renderView('withdraw-money', ['title' => 'Nuskaičiuoti lėšas']);
    }
}
