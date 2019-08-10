<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
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
use Illuminate\Support\Facades\File;

class AjaxController extends Controller {
    
    public function get() {
        $mode = request("mode");

        switch ($mode) {
            case 'getProductList':
                if (request("query") == "") {
                    $response["query"] = Products::take(12)->get();
                }
                else {
                    $query = str_replace(" ", "|", request("query"));
                    $response["query"] = Products::take(12)->where("name", "regexp", $query)->orWhere("brand", "regexp", $query)->orWhere("code", "regexp", $query)->orderBy("id", "DESC")->get();
                }
                break;

            case "sell":
                if(Data::isOpen()){
                    $canSell = true;
                    $productsOutOfStock = [];
                    $cart = request()->all();
                    $disccount = $cart["disccount"];
                    $subtotal = $cart["total"];
                    $payment_method = $cart["payment_method"];
                    $comment = $cart["comment"];
                    $total = $subtotal -(($disccount * $subtotal) / 100);
                    unset($cart["disccount"]);
                    unset($cart["total"]);
                    unset($cart["mode"]);
                    unset($cart["comment"]);
                    unset($cart["payment_method"]);

                    //Primero verificamos que haya productos en stock
                    foreach ($cart as $key => $product) {
                        $id = (int) substr($key, 1);
                        $quantity = $product["quantity"];

                        $product = Products::find($id);
                        if ($quantity > $product->stock) {
                            $canSell = false;
                            array_push($productsOutOfStock, $product->name." (Stock: $product->stock)");
                        }
                    }

                    //Si no hay productos fuera del stock
                    if ($canSell) {
                        //Luego creamos la venta
                        $sale = Sales::create([
                            "user" => auth()->user()->id,
                            "disccount" => $disccount,
                            "payment_method" => $payment_method,
                            "subtotal" => $subtotal,
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
    
                            //Descontamos el stock
                            $product = Products::find($id);
                            $product->stock -= $quantity;
                            $product->save();
    
                            //Lo insertamos en la tabla de ventas
                            Sold::newSale($id, $quantity, $price, $saleId);
    
                            //Lo insertamos en los logs
                            Logs::createLog("Vendió $quantity $name por $$price ARS");
                            ;
    
                        }
                        
                        //Actualizo el total de la caja
                        Data::updatePrice($total, "add");
                        $response["outOfStock"] = "false";
                        $response["status"] = "true";
                        $response["id"] = $saleId;
                    }
                    else {
                        $response["status"] = false;
                        $response["outOfStock"] = "true";
                        $response["productsOutOfStock"] = $productsOutOfStock;
                        $response["message"] = "Lo sentimos, los siguientes productos fueron vendidos recientemente por lo que ya no están en el stock o no hay suficientes:";
                    }
                }
                else {
                    $response["outOfStock"] = "false";
                    $response["status"] = "false";
                    $response["message"] = "No se pueden realizar ventas mientras la caja está cerrada.";
                }
                break;

            case "closeCashRegister":
            case "openCashRegister":
                $open = $mode == "openCashRegister";

                //Si la acción solicitada es abrir y la caja está abierta, o si la cción solicitada es cerrar y la caja está cerrada, alertamos al usuario
                if (($open && Data::isOpen()) || (!$open && !Data::isOpen())) {
                    $action = $open ? "abierta" : "cerrada";
                    $response["status"] = "false";
                    $response["isOpenCloseError"] = "true";
                    $response["message"] = "La caja ya fue $action por otra persona.";
                }
                else {
                    $action = $open ? "Abrió" : "Cerró";
                    Data::setStatus($open);
    
                    if (!$open) Artisan::call("backup:run");
    
                    $log = "$action la caja con $".Data::getBalance()." ARS";
                    Logs::createLog($log);
                    
                    $response["status"] = "true";
                    $response["log"]["text"] = $log;
                    $response["log"]["timestamp"] = date("Y-m-d H:i:s");
                    $response["username"] = auth()->user()->username;
                }

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
                    $response["username"] = auth()->user()->username;
                    $response["balance"] = Data::getBalance();
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
                $response["username"] = auth()->user()->username;
                $response["balance"] = Data::getBalance();
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
                    $item["id"] = $product->id;
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
                Logs::createLog("Editó el nombre del proveedor de $provider->name a $name");
                $provider->name = $name;
                $provider->save();
                $response["status"] = "true";
                break;

            case 'editCategory':
                $id = request("id");
                $id = substr($id, 2);
                $name = request("name");
                $category = Categories::find($id);
                Logs::createLog("Editó el nombre de la categoría de $category->name a $name");
                $category->name = $name;
                $category->save();
                $response["status"] = "true";
                break;

            case 'AddProviders':
                $name = request("name");
                $newProvider = Providers::create([
                    "name" => $name
                ]);
                Logs::createLog('Agregó el proveedor "'.$name.'"');
                $response["status"] = "true";
                $response["id"] = $newProvider->id;
                break;

            case 'AddCategories':
                $name = request("name");
                $newCategory = Categories::create([
                    "name" => $name
                ]);
                Logs::createLog('Agregó la categoría "'.$name.'"');
                $response["status"] = "true";
                $response["id"] = $newCategory->id;
                break;

            case 'deleteProvider':
                    $id = request("id");
                    $id = substr($id, 2);
                    $provider = Providers::find($id);
                    $name = $provider->name;
                    $provider->delete();
                    Logs::createLog('Eliminó el proveedor "'.$name.'" junto con todos los productos asociados a el.');
                    $response["status"] = "true";
                    break;

            case 'deleteCategory':
                    $id = request("id");
                    $id = substr($id, 2);
                    $category = Categories::find($id);
                    $name = $category->name;
                    $category->delete();
                    Logs::createLog('Eliminó la categoría "'.$name.'" junto con todos los productos asociados a ella.');
                    $response["status"] = "true";
                    break;

            case 'deleteProduct':
                    $id = request("id");
                    $id = substr($id, 3);
                    $product = Products::find($id);
                    $name = $product->name;
                    $product->delete();
                    Logs::createLog('Eliminó el producto "'.$name.'"');
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

                            Logs::createLog('Creó el producto "'.$product->name.'"');
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
                            $oldImage = public_path()."/media/images/uploaded_images/".$product->image;
                            //Primero busco la imagen actual para quitarla
                            if (file_exists($oldImage)) File::delete($oldImage);
                            $product->image = $image["name"];
                            $response["image"] = $image["name"];
                        }
                        else {
                            $response["warning"] = "La imagen no se pudo subir";
                        }
                    }

                    Logs::createLog('Editó el producto "'.$product->name.'"');

                    $product->save();
                    $response["status"] = "true";
                    break;

            case 'getMoreLogs':
                    $logsChargeds = request("logsChargeds");
                    $logs = Logs::skip($logsChargeds)->take(10)->orderBy("id", "DESC")->get();
                    $allLogs = Logs::count();
                    $send = [];
                    foreach($logs as $log) {
                        $item["action"] = $log->action;
                        $item["created_at"] = $log->created_at;
                        $item["id"] = $log->id;
                        $item["username"] = $log->userinfo->username;
                        array_push($send, $item);
                    }
                    $response["log"] = $send;
                    $response["allLogs"] = $allLogs;
                    break;

            case 'deleteSold':
                    //Obtengo datos
                    $id = request("id");
                    $idSale = request("idSale");

                    //Busco en la base de datos
                    $sale = Sales::find($idSale);
                    $sold = Sold::find($id);

                    //Actualizo datos
                    $sale->total -= $sold->payed;
                    $sale->save();
                    $sale->fresh();
                    Data::updatePrice($sold->payed, "withdrawal");

                    //Creo el log
                    $date = get_short_date_from_timestamp($sale->created_at)." ".get_time_from_timestamp($sale->created_at);
                    $name = $sold->productinfo->name;
                    Logs::createLog('Eliminó "'.$name.'" de la venta del '.$date);

                    //Elimino el registro
                    $sold->delete();

                    //Respondo
                    $response["status"] = "true";
                    $response["newTotal"] = $sale->total;
                    break;

            case 'addProductSold':
                    //Obtenemos datos
                    $quantity = request("quantity");
                    $id = substr(request("productId"), 1);
                    $saleId = request("saleId");

                    //Buscamos en la base de datos
                    $product = Products::find($id);
                    $sale = Sales::find($saleId);
                    
                    //Insertamos en la tabla de vendidos
                    $price = $product->public_price * $quantity;
                    $subtotal = $sale->subtotal + $price;
                    $sale->subtotal = $subtotal;
                    $sale->total = $subtotal - (($sale->disccount * $subtotal) / 100);
                    $sold = Sold::newSale($product->id, $quantity, $price, $saleId);
                    $sale->save();
                    $sale->fresh();
                    Data::updatePrice($price, "add");

                    //Descontamos del stock
                    $product->stock -= $quantity;
                    $product->save();

                    //Creamos el log
                    $date = get_short_date_from_timestamp($sale->created_at)." ".get_time_from_timestamp($sale->created_at);
                    Logs::createLog('Añadió el producto "'.$product->name.'" a la venta del '.$date);

                    //Respondemos
                    $response["status"] = "true";
                    $response["id"] = $sold->id;
                    $response["image"] = $product->image;
                    $response["name"] = $product->name;
                    $response["description"] = $product->description;
                    $response["payed"] = $price;
                    $response["newTotal"] = $sale->total;
                    $response["quantity"] = $quantity;
                    break;

            case 'deleteSale':
                    $id = request("id");
                    $sale = Sales::find($id);

                    Data::updatePrice($sale->total, "withdrawal");
                    $date = get_short_date_from_timestamp($sale->created_at)." ".get_time_from_timestamp($sale->created_at);

                    //Creo el log
                    Logs::createLog("Eliminó la venta del $date, se extrajeron $$sale->total ARS de la caja.");

                    $sale->delete();

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
