<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Get routes

Route::get('/', "Store@getSells")->name("ventas");

Route::get('/caja', "Store@getCashRegister")->name("caja");

Route::get('/product/{product}', "Products@getProduct")->name("product");

Route::get('/products', "Products@getProductDashboard")->name("products");

Route::get('/login', "Users@getLoginForm")->name("login");

Route::get('/logout', "Users@logout")->name("logout");

Route::get('/register', "Users@getRegisterForm")->name("register");

Route::get('/vendidos/{page}', "Store@getSolds")->name("vendidos");

Route::get('/sale/{sale}', "Store@getSales")->name("sale");

Route::get('/ticket/{sale}', "Products@getTicket")->name("ticket");

Route::get('/products/export', "Products@export")->name("products.export");

//Post routes

Route::post('/ajax-requests', "AjaxController@get")->name("ajax-requests");

Route::post('/login', "Auth\LoginController@login")->name("post-login");

Route::post('/register', "Auth\RegisterController@create")->name("post-register");

