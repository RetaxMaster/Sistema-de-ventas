<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model {
    
    protected $fillable = ["name", "brand", "category", "public_price", "major_price", "provider_price", "code", "provider", "sell_type", "description", "stock", "weight", "size", "image"];

    public static function fillFakeData() {
        factory(static::class, 10)->create();        
    }

    // Relaciones
    
    public function categoryinfo() {
        return $this->belongsTo(Categories::class, 'category');
    }

    public function providerinfo() {
        return $this->belongsTo(Providers::class, 'provider');
    }

    public function solds() {
        return $this->hasMany(Sold::class, 'product');
    }
    
    // -> Relaciones
}
