<?php

namespace App\Controllers\Usuario;
use App\Controllers\BaseController;


class Logout extends BaseController {

    public function index(){
        $session = session();
        $session-> destroy();
        return redirect()->to(route_to("acceso"));
    }
}   
