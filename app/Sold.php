<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sold extends Model {

    protected $fillable = ["user", "product", "quantity"];
    protected $table = "sold";

    public static function fillFakeData() {
        factory(static::class, 3)->create();        
    }

    // Relaciones
    
    public function productinfo() {
        return $this->belongsTo(Products::class, 'product');
    }

    public function userinfo() {
        return $this->belongsTo(User::class, 'user');
    }
    
    // -> Relaciones
}
