<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Users extends Controller {
    
    // Regresa la lista de productos para vender
    public function getLoginForm() {

        $mode = "login";

        $variables = compact("mode");
        return view("user", $variables);
    }

    // Regresa la lista de productos para vender
    public function getRegisterForm() {

        $mode = "register";

        $variables = compact("mode");
        return view("user", $variables);
    }

}
