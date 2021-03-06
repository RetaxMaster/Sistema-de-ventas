<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model {
    
    protected $fillable = ["user", "disccount", "payment_method", "subtotal", "total", "comment", "ticket_url"];

    public static function fillFakeData() {
        factory(static::class, 3)->create();        
    }

    // Relaciones
    
    public function solds() {
        return $this->hasMany(Sold::class, 'sale');
    }

    public function userinfo() {
        return $this->belongsTo(User::class, 'user');
    }
    
    // -> Relaciones

}
