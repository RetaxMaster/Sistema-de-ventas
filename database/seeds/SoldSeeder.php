<?php

use Illuminate\Database\Seeder;
use App\Sold;

class SoldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Sold::fillFakeData();                
    }
}
