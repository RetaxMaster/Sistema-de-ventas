<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model {
    
    protected $fillable = ["name", "brand", "category", "public_price", "major_price", "provider_price", "code", "provider", "sell_type", "description", "stock", "image"];

    public static function fillFakeData() {
        factory(static::class, 10)->create();        
    }
}
