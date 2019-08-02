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

Route::get('/', function () {
    return "Working";
});

Route::get('/caja', function () {
    return view("caja");
});

Route::get('/product', function () {
    return view("product");
});

Route::get('/products', function () {
    return view("products");
});

Route::get('/user', function () {
    return view("user");
});

Route::get('/vendidos', function () {
    return view("vendidos");
});

Route::get('/ventas', function () {
    return view("ventas");
});

