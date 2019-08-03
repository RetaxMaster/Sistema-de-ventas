<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model {

    protected $fillable = ["action", "user"];

    // Rleaciones
    
    //User
    public function userinfo() {
        return $this->belongsTo(User::class, 'user');
    }
    
    // -> Rleaciones

    public static function fillFakeData() {
        factory(static::class, 5)->create();        
    }
}
