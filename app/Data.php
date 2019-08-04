<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model {

    protected $casts = ["is_open" => "boolean",];
    protected $fillable = ["cash_register", "is_open"];

    public static function fillFakeData() {
        factory(static::class)->create();        
    }

    public static function updatePrice(float $price, string $action) {
        $cash_register = parent::first();

        switch ($action) {
            case 'set':
                $cash_register->cash_register = $price;
                break;

            case 'add':
                $cash_register->cash_register += $price;
                break;

            case 'withdrawal':
                $cash_register->cash_register -= $price;
                break;
        }

        $cash_register->save();
    }

    public static function setStatus(bool $status) {
        $cash_register = parent::first();
        $cash_register->is_open = $status;
        $cash_register->save();
    }

    public static function isOpen() : bool {
        $cash_register = parent::first();
        return $cash_register->is_open;
    }

    public static function getBalance() : float {
        $cash_register = parent::first();
        return $cash_register->cash_register;
    }
}
