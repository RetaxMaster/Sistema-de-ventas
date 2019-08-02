<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Users extends Controller {
    
    // Regresa la lista de productos para vender
    public function getLoginForm() {
        return view("user");
    }

    // Regresa la lista de productos para vender
    public function getRegisterForm() {
        return view("user");
    }

}
