<?php

namespace app\Controllers;

use app\Controllers\Controller;

class SiteController extends Controller
{
    public function home()
    {
        return $this->renderView('main', 'home', [
            'title' => 'Sąskaitų sąrašas',
            'active' => 'home'
        ]);
    }

    public function createAcc()
    {
        return $this->renderView('main', 'create-acc', [
            'title' => 'Sukurti sąskaitą',
            'active' => 'create-acc'
        ]);
    }

    public function login()
    {
        return $this->renderView('auth', 'login', ['title' => 'Prisijungimas']);
    }

    public function addMoney()
    {
        return $this->renderView('main', 'add-money', ['title' => 'Pridėti lėšas']);
    }

    public function withdrawMoney()
    {
        return $this->renderView('main', 'withdraw-money', ['title' => 'Nuskaičiuoti lėšas']);
    }
}
