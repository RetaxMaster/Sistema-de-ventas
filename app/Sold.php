<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sold extends Model {
    public static function fillFakeData() {
        factory(static::class, 3)->create();        
    }
}
