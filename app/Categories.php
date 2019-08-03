<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model {

    protected $fillable = ["name"];
    
    public static function fillFakeData() {
        factory(static::class, 4)->create();        
    }

    // Relaciones
    
    public function products() {
        return $this->hasMany(Products::class, 'category');
    }
    
    // -> Relaciones

}
