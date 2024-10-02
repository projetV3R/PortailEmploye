<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UsagerSeeder;
use Database\Seeders\ParametreSystemeSeeder;
use Database\Seeders\ModeleSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsagerSeeder::class);
        $this->call(ParametreSystemeSeeder::class);
        $this->call(ModeleSeeder::class);
        
    }
}
