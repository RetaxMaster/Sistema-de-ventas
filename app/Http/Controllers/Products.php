<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Products extends Controller {
    
    // Regresa la descripción del producto
    public function getProduct() {
        return view("product");
    }

    // Regresa el dashboard para agregar productos
    public function getProductDashboard() {
        return view("products");
    }

}
