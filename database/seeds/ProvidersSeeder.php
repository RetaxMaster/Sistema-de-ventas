<?php

use Illuminate\Database\Seeder;
use App\Providers;

class ProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Providers::fillFakeData();        
    }
}
