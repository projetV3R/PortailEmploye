<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;


class UsagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usagers')->insert([
        [
            'id' =>1,
            'email' => 'john@test.com',
            'password' =>Hash::make('password'),
            'nom' => 'coco',
            'prenom' => 'jahn',
            'role'=>'admin',
        ],
        [
            'id' =>2,
            'email' => 'nono@test.com',
            'password' =>Hash::make('1234'),
            'nom' => 'momo',
            'prenom' => 'chch',
            'role'=>'responsable',
        ],
        [
            'id' =>3,
            'email' => 'popet@test.com',
            'password' =>Hash::make('1234'),
            'nom' => 'popet',
            'prenom' => 'fofo',
            'role'=>'commis',
        ],
        [
            'id' =>4,
            'email' => 'chanel@test.com',
            'password' =>Hash::make('1234'),
            'nom' => 'chanel',
            'prenom' => 'toto',
            'role'=>'commis',
        ],
    ]);
    }
}
