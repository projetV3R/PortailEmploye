<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usagers')->insert(
        [[
            'id' =>1,
            'email' => 'john@test.com',
            'password' =>Hash::make('password'),
            'nom' => 'coco',
            'prenom' => 'jahn',
            'role'=>'admin',
        ],
        [
            'id' =>2,
            'email' => 'jochua',
            'password' =>Hash::make('password'),
            'nom' => 'fdf',
            'prenom' => 'jaerehn',
            'role'=>'admin',
        ],]
    );
    }
}
