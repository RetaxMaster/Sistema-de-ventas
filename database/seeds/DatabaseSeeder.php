<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(ProvidersSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(DataSeeder::class);
        $this->call(LogsSeeder::class);
    }
}
