<?php

namespace App\Http\Controllers;
use App\Products as ProductDatabase;
use App\Categories;
use App\Providers;

use Illuminate\Http\Request;

class Products extends Controller {
    
    // Regresa la descripción del producto
    public function getProduct(ProductDatabase $product) {
        $variables = compact("product");
        return view("product", $variables);
    }

    // Regresa el dashboard para agregar productos
    public function getProductDashboard() {

        $categories = Categories::orderBy("id", "DESC")->get();
        $providers = Providers::orderBy("id", "DESC")->get();
        $products = ProductDatabase::all();

        $variables = compact("categories", "providers", "products");

        return view("products", $variables);
    }

}
