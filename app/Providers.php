<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Providers extends Model {

    protected $fillable = ["name"];

    public static function fillFakeData() {
        factory(static::class, 3)->create();        
    }

    // Relaciones
    
    public function products() {
        return $this->hasMany(Products::class, 'provider');
    }
    
    // -> Relaciones
}
