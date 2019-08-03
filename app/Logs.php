<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model {

    protected $fillable = ["action", "user"];

    public static function fillFakeData() {
        factory(static::class, 5)->create();        
    }
}
