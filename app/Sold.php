<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sold extends Model {

    protected $fillable = ["product", "quantity", "payed", "sale"];
    protected $table = "sold";

    public static function fillFakeData() {
        factory(static::class, 100)->create();        
    }

    // Relaciones
    
    public function productinfo() {
        return $this->belongsTo(Products::class, 'product');
    }

    public function saleinfo() {
        return $this->belongsTo(User::class, 'sale');
    }
    
    // -> Relaciones

    public static function newSale(int $id, int $quantity, float $payed, int $sale) {
        return parent::create([
            "product" => $id,
            "quantity" => $quantity,
            "payed" => $payed,
            "sale" => $sale
        ]);
    }
}
