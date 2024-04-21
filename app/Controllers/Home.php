<?php

namespace App\Controllers;

class Home extends BaseController {
    public function index()
    {
        return view('welcome_message');
    }

    public function ejemplo(){
        return view('ejemplo2');
    }
}
