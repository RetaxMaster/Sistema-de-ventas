<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use App\Sold;
use App\Logs;
use App\Data;

class AjaxController extends Controller {
    
    public function get() {
        $mode = request("mode");

        switch ($mode) {
            case 'getProductList':
                $query = str_replace(" ", "|", request("query"));
                $response["query"] = Products::take(12)->where("name", "regexp", $query)->get();
                break;

            case "sell":
                if(Data::isOpen()){
                    $cart = request()->all();
                    $disccount = $cart["disccount"];
                    $total = $cart["total"];
                    $payment_method = $cart["payment_method"];
                    unset($cart["disccount"]);
                    unset($cart["total"]);
                    unset($cart["mode"]);
                    unset($cart["payment_method"]);

                    foreach ($cart as $key => $product) {
                        $id = (int) substr($key, 1);
                        $quantity = $product["quantity"];
                        $price = $product["price"];
                        $name = $product["name"];

                        //Lo insertamos en la tabla de ventas
                        Sold::newSale($id, $quantity, $disccount, $price, $payment_method);

                        //Lo insertamos en los logs
                        Logs::createLog("Vendió $quantity $name por $$price ARS");
                        ;

                    }
                    
                    //Actualizo el total de la caja
                    Data::updatePrice($total, "add");
                    $response["status"] = "true";
                }
                else {
                    $response["status"] = "false";
                    $response["message"] = "No se pueden realizar ventas mientras la caja está cerrada.";
                }
                break;

            case "closeCashRegister":
            case "openCashRegister":
                $open = $mode == "openCashRegister";
                $action = $open ? "Abrió" : "Cerró";
                Data::setStatus($open);

                $log = "$action la caja con $".Data::getBalance()." ARS";
                Logs::createLog($log);
                
                $response["status"] = "true";
                $response["log"]["text"] = $log;
                $response["log"]["timestamp"] = date("Y-m-d H:i:s");
                break;

            case 'withdrawal':
                $value = request("value");
                if (Data::getBalance() >= $value) {
                    Data::updatePrice($value, "withdrawal");
                    
                    $log = "Retiró $$value ARS";
                    Logs::createLog($log);
                    
                    $response["log"]["text"] = $log;
                    $response["log"]["timestamp"] = date("Y-m-d H:i:s");
                    $response["status"] = "true";
                }
                else {
                    $response["status"] = "false";
                    $response["message"] = "No hay suficientes fondos en la caja.";
                }
                break;

            case "setBalance":
                $value = request("value");
                
                $log = "Estableció el monto de la caja de $".Data::getBalance()." ARS a $$value ARS";
                Logs::createLog($log);
                
                Data::updatePrice($value, "set");
                
                $response["log"]["text"] = $log;
                $response["log"]["timestamp"] = date("Y-m-d H:i:s");
                $response["status"] = "true";
                break;

            case "searchSold":
                $query = str_replace(" ", "|", request("query"));
                $products = Products::take(12)->where("name", "regexp", $query)->get();
                $soldProducts = [];

                foreach ($products as $product) {
                    if (count($product->solds) > 0) {
                        foreach ($product->solds as $sold) {
                            $item = [];
                            $item["id"] = $product->id;
                            $item["image"] = $product->image;
                            $item["name"] = $product->name;
                            $item["description"] = $product->description;
                            $item["price"] = $sold->payed;
                            $item["username"] = $sold->userinfo->username;
                            $item["quantity"] = $sold->quantity;
                            array_push($soldProducts, $item);
                        }
                    }
                }
                $response["query"] = $soldProducts;
                break;

            default:
                $response["status"] = "false";
                $response["message"] = "No se encontró la acción especificada";
                break;
        }
    
        return json_encode($response);
    }

}
