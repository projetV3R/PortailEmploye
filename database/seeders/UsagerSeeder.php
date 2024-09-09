<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usagers')->insert([
            'id' =>1,
            'email' => 'john@test.com',
            'motDePasse' =>'password',
            'nom' => '',
            'prenom' => 'jahn',
            'role'=>'admin',
        ]);
    }
}
