<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class Users extends Controller {

    public function __construct() {
        $this->middleware("guest", ["only" => "getLoginForm"]);
        $this->middleware("admin", ["only" => "getRegisterForm"]);
    }
    
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

    //Cierra la sesión
    public function logout() {
        Auth::logout();

        return redirect()->route("login");
    }

}
