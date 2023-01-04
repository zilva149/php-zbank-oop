<?php

namespace app\Controllers;

use app\Controllers\Controller;

class SiteController extends Controller
{
    public function home()
    {
        echo 'Home page';
    }

    public function contacts()
    {
        echo 'Contact us';
    }
}
