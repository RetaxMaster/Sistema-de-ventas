<?php

use Illuminate\Database\Seeder;
use App\Sales;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Sales::fillFakeData();                
    }
}
