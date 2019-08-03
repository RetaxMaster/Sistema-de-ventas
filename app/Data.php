<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model {

    protected $casts = ["is_open" => "boolean",];
    protected $fillable = ["cash_register", "is_open"];

    public static function fillFakeData() {
        factory(static::class)->create();        
    }
}
