<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;

class LoginController extends Controller {

    public function login() {
        
        //Validación de datos
        $credentials = $this->validate(request(), [
            "username" => "required|string",
            "password" => "required|string"
        ]);

        if(Auth::attempt($credentials)) {
            return (auth()->user()->rol == 1) ? redirect()->route("ventas") : redirect()->route("products");
        }

        return back()->withErrors(["login_failed" => "Usuario o contraseña incorrectos."]);

    }

}
