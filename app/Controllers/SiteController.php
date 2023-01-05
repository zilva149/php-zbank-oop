<?php

namespace app\Controllers;

class SiteController extends Controller
{
    public function home(): void
    {
        echo ViewController::renderView('home', [
            'title' => 'Sąskaitų sąrašas',
            'active' => 'home'
        ]);
    }

    public function createAcc(): void
    {
        echo ViewController::renderView('create-acc', [
            'title' => 'Sukurti sąskaitą',
            'active' => 'create-acc'
        ]);
    }

    public function login(): void
    {
        echo ViewController::renderView('login', ['title' => 'Prisijungimas']);
    }

    public function addMoney(): void
    {
        echo ViewController::renderView('add-money', ['title' => 'Pridėti lėšas']);
    }

    public function withdrawMoney(): void
    {
        echo ViewController::renderView('withdraw-money', ['title' => 'Nuskaičiuoti lėšas']);
    }
}
