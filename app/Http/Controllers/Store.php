<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data;
use App\Logs;
use App\Sales;
use App\Products;

class Store extends Controller {
    // Regresa la caja
    public function getCashRegister() {
        $data = Data::first();
        $ammount = $data->cash_register;
        $is_open = $data->is_open;
        $disabled = $is_open ? "" : "disabled";
        $open_cash_register = $is_open ? "hidden" : "";
        $close_cash_register = !$is_open ? "hidden" : "";
        $logs = Logs::take(10)->orderBy("id", "DESC")->get();

        $variables = compact("ammount", "is_open", "logs", "disabled", "open_cash_register", "close_cash_register");

        return view("caja", $variables);
    }

    // Regresa la lista de productos para vender
    public function getSells() {
        $products = Products::take(10)->orderBy("id", "DESC")->get();
        $variables = compact("products");
        return view("ventas", $variables);
    }

    // Regresa la lista de productos vendidos
    public function getSolds($page) {
        
        // Obtengo los articulos paginados
        
        $resultsPerPage = 10;
        $allProducts = Sales::count();

        if ($allProducts > 0) {
            $showPagination = true;
            $totalPages = ceil($allProducts / $resultsPerPage);
            if($page > $totalPages) return abort(404);
            $start = $page * $resultsPerPage - $resultsPerPage;
            $sales = Sales::skip($start)->take($resultsPerPage)->orderBy("id", "DESC")->get();
    
            // Next y prev
            
            $next = $page + 1;
            $prev = $page - 1;
            $next = ($next > $totalPages) ? null : $next;
            $prev = ($prev < 1) ? null : $prev;
            $link_next = route("vendidos", ["page" => $next]);
            $link_prev = route("vendidos", ["page" => $prev]);
            
            // -> Next y prev
    
    
            //Obteniendo el valor de $i para la paginación
            $start_for = ($page >= $totalPages - 2) ? (($totalPages > 5) ? ($totalPages - 4) : 1) : (($page > 3) ? (1 + ($page-3)) : 1);
        }
        else {
            $showPagination = false;
            $solds = [];
            $totalPages = "";
            $page = "";
            $start_for = "";
            $next = "";
            $prev = "";
            $link_next = "";
            $link_prev = "";
        }
        
        // -> Obtengo los articulos paginados

        $variables = compact("sales", "totalPages", "page", "start_for", "next", "prev", "link_next", "link_prev", "showPagination");
        return view("vendidos", $variables);
    }

}
