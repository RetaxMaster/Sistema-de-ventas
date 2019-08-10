<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade as PDF;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Products as ProductDatabase;
use App\Categories;
use App\Providers;
use App\Sales;

use Illuminate\Http\Request;

class Products extends Controller {

    public function __construct() {
        $this->middleware("auth");
        $this->middleware("admin", ["except" => ["getProduct", "getTicket", "export"]]);
    }
    
    // Regresa la descripción del producto
    public function getProduct(ProductDatabase $product) {
        $variables = compact("product");
        return view("product", $variables);
    }

    // Regresa el dashboard para agregar productos
    public function getProductDashboard() {

        $categories = Categories::orderBy("id", "DESC")->get();
        $providers = Providers::orderBy("id", "DESC")->get();
        $products = ProductDatabase::orderBy("id", "DESC")->get();

        $variables = compact("categories", "providers", "products");

        return view("products", $variables);
    }

    //Obtiene el ticket
    public function getTicket(Sales $sale) {

        $date = get_short_date_from_timestamp($sale->created_at)." ".get_time_from_timestamp($sale->created_at);
        $disccount = (($sale->disccount * $sale->subtotal) / 100);
        $variables = compact("sale", "date", "disccount");
        $pdf = PDF::loadView("tickets/ticket", $variables);
        return $pdf->stream();
    }

    //Exporta la lista de productos
    public function export() {
        return Excel::download(new ProductsExport, 'Productos.xlsx');
    }
    

}
