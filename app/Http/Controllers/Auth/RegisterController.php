<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller {

    protected function create() {

        //Validación de datos
        $credentials = $this->validate(request(), [
            "username" => "required|string|unique:users",
            "password" => "required|string",
            'rol' => "required"
        ]);

        User::create([
            'username' => $credentials['username'],
            'rol' => $credentials['rol'],
            'password' => bcrypt($credentials['password']),
        ]);

        return back()->with("registered", "Usuario registrado con éxito");
    }

}
