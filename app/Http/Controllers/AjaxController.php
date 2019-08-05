<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use App\Sold;
use App\Logs;
use App\Data;
use App\Providers;
use App\Categories;
use App\Sales;
use App\Classes\RetaxMaster;
use Illuminate\Support\Facades\DB;

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
                    $comment = $cart["comment"];
                    unset($cart["disccount"]);
                    unset($cart["total"]);
                    unset($cart["mode"]);
                    unset($cart["comment"]);
                    unset($cart["payment_method"]);

                    //Primero generamos el ticket
                    //TODO: Generar ticket

                    //Luego creamos la venta
                    $sale = Sales::create([
                        "user" => 1,
                        "disccount" => $disccount,
                        "payment_method" => $payment_method,
                        "total" => $total,
                        "comment" => $comment != "" ? $comment : null,
                        "ticket_url" => "asd"
                    ]);

                    $saleId = $sale->id;

                    //Después insertamos cada producto por individual
                    foreach ($cart as $key => $product) {
                        $id = (int) substr($key, 1);
                        $quantity = $product["quantity"];
                        $price = $product["price"];
                        $name = $product["name"];

                        //Lo insertamos en la tabla de ventas
                        Sold::newSale($id, $quantity, $price, $saleId);

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
                $id = request("id");
                $id = substr($id, 1);
                $response["id"] = $id;
                $products = Sales::find($id);
                $username = $products->userinfo->username;
                $response["description"] = $products->comment;
                $products = $products->solds;
                $soldProducts = [];

                foreach ($products as $product) {
                    $item = [];
                    $item["id"] = $product->productinfo->id;
                    $item["image"] = $product->productinfo->image;
                    $item["name"] = $product->productinfo->name;
                    $item["description"] = $product->productinfo->description;
                    $item["price"] = $product->payed;
                    $item["username"] = $username;
                    $item["quantity"] = $product->quantity;
                    array_push($soldProducts, $item);
                }
                $response["products"] = $soldProducts;
                break;

            case 'searchSales':
                $start = convert_normal_date_to_timestamp(request("start"));
                $end = convert_normal_date_to_timestamp(request("end"));
                $sales = Sales::whereBetween("created_at", [$start, $end])->get();
                $data = [];
                foreach ($sales as $key => $sale) {
                    $data[$key]["id"] = $sale->id;
                    $data[$key]["username"] = $sale->userinfo->username;
                    $data[$key]["quantity"] = count($sale->solds);
                    $data[$key]["timestamp"] = $sale->created_at;
                    $data[$key]["total"] = $sale->total;
                }
                $response["query"] = $data;
                break;

            case 'editProvider':
                $id = request("id");
                $id = substr($id, 2);
                $name = request("name");
                $provider = Providers::find($id);
                $provider->name = $name;
                $provider->save();
                $response["status"] = "true";
                break;

            case 'editCategory':
                $id = request("id");
                $id = substr($id, 2);
                $name = request("name");
                $category = Categories::find($id);
                $category->name = $name;
                $category->save();
                $response["status"] = "true";
                break;

            case 'AddProviders':
                $newProvider = Providers::create([
                    "name" => request("name")
                ]);
                $response["status"] = "true";
                $response["id"] = $newProvider->id;
                break;

            case 'AddCategories':
                $newCategory = Categories::create([
                    "name" => request("name")
                ]);
                $response["status"] = "true";
                $response["id"] = $newCategory->id;
                break;

            case 'deleteProvider':
                    $id = request("id");
                    $id = substr($id, 2);
                    Providers::destroy($id);
                    $response["status"] = "true";
                    break;

            case 'deleteCategory':
                    $id = request("id");
                    $id = substr($id, 2);
                    Categories::destroy($id);
                    $response["status"] = "true";
                    break;

            case 'deleteProduct':
                    $id = request("id");
                    $id = substr($id, 3);
                    Products::destroy($id);
                    $response["status"] = "true";
                    break;

            case 'addProduct':
                    if (request()->hasFile("Picture")) {
                        $image = RetaxMaster::uploadImage(request()->file("Picture"));
                        if (isset($image["name"])) {
                            $product = Products::create([
                                "name" => request("Nombre"),
                                "brand" => request("Marca"),
                                "category" => request("Categoria"),
                                "public_price" => request("PublicPrice"),
                                "major_price" => request("MajorPrice"),
                                "provider_price" => request("ProviderPrice"),
                                "code" => request("Code"),
                                "provider" => request("Provider"),
                                "sell_type" => request("SellType"),
                                "description" => request("Description"),
                                "stock" => request("Stock"),
                                "weight" => request("Weight"),
                                "size" => request("Size"),
                                "image" => $image["name"]
                            ]);
                            $response["status"] = "true";
                            $response["name"] = $product->name;
                            $response["description"] = $product->description;
                            $response["image"] = $product->image;
                            $response["id"] = $product->id;
                        }
                        else {
                            $response = $image;
                        }
                    }
                    break;

            case 'editProduct':
                    $id = request("id");
                    $id = substr($id, 3);
                    $product = Products::find($id);
                    if(request("Nombre") != null) {
                        $product->name = request("Nombre");
                        $response["name"] = request("Nombre");
                    }
                    if(request("Marca") != null) $product->brand = request("Marca");
                    if(request("Categoria") != null) $product->category = request("Categoria");
                    if(request("PublicPrice") != null) $product->public_price = request("PublicPrice");
                    if(request("MajorPrice") != null) $product->major_price = request("MajorPrice");
                    if(request("ProviderPrice") != null) $product->provider_price = request("ProviderPrice");
                    if(request("Code") != null) $product->code = request("Code");
                    if(request("Provider") != null) $product->provider = request("Provider");
                    if(request("SellType") != null) $product->sell_type = request("SellType");
                    if(request("Description") != null) {
                        $product->description = request("Description");
                        $response["description"] = request("Description");
                    }
                    if(request("Stock") != null) $product->stock = request("Stock");
                    if(request("Weight") != null) $product->weight = request("Weight");
                    if(request("Size") != null) $product->size = request("Size");

                    if (request()->hasFile("Picture")) {
                        $image = RetaxMaster::uploadImage(request()->file("Picture"));
                        if (isset($image["name"])) {
                            $product->image = $image["name"];
                            $response["image"] = $image["name"];
                        }
                        else {
                            $response["warning"] = "La imagen no se pudo subir";
                        }
                    }

                    $product->save();
                    $response["status"] = "true";
                    break;

            default:
                $response["status"] = "false";
                $response["message"] = "No se encontró la acción especificada";
                break;
        }
    
        return json_encode($response);
    }

}
