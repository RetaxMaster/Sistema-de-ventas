<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sold extends Model {

    protected $fillable = ["user", "product", "quantity", "disccount", "payed", "payment_method"];
    protected $table = "sold";

    public static function fillFakeData() {
        factory(static::class, 50)->create();        
    }

    // Relaciones
    
    public function productinfo() {
        return $this->belongsTo(Products::class, 'product');
    }

    public function userinfo() {
        return $this->belongsTo(User::class, 'user');
    }
    
    // -> Relaciones

    public static function newSale(int $id, int $quantity, int $disccount, float $payed, int $payment_method) {
        parent::create([
            "user" => 1,
            "product" => $id,
            "quantity" => $quantity,
            "disccount" => $disccount,
            "payed" => $payed,
            "payment_method" => $payment_method
        ]);
    }
}
