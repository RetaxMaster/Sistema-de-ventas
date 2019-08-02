<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Store extends Controller 
{
    // Regresa la caja
    public function getCashRegister() {
        return view("caja");
    }

    // Regresa la lista de productos para vender
    public function getSells() {
        return view("ventas");
    }

    // Regresa la lista de productos vendidos
    public function getSelled() {
        return view("vendidos");
    }

}
