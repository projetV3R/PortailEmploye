<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UsagerSeeder;
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
    }
}
