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

        $this->truncateTables(["categories", "providers", "products", "sold", "data", "logs", "users"]);

        $this->call(UsersSeeder::class);
        $this->call(DataSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(ProvidersSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(SalesSeeder::class);
        $this->call(SoldSeeder::class);
        $this->call(LogsSeeder::class);
    }

    public function truncateTables(array $tables) {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        foreach ($tables as $table) DB::table($table)->truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
    }
}
