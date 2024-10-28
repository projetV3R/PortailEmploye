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
            [
                [
                    'id' => 1,
                    'email' => 'amelia101@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Amélie',
                    'prenom' => 'Dupuis',
                    'role' => 'admin',
                ],
                [
                    'id' => 2,
                    'email' => 'benjamin102@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Benjamin',
                    'prenom' => 'Lemaire',
                    'role' => 'responsable',
                ],
                [
                    'id' => 3,
                    'email' => 'chloe103@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Chloé',
                    'prenom' => 'Gauvin',
                    'role' => 'commis',
                ],
                [
                    'id' => 4,
                    'email' => 'david104@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'David',
                    'prenom' => 'Boucher',
                    'role' => 'admin',
                ],
                [
                    'id' => 5,
                    'email' => 'elaine105@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Elaine',
                    'prenom' => 'Caron',
                    'role' => 'responsable',
                ],
                [
                    'id' => 6,
                    'email' => 'francis106@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Francis',
                    'prenom' => 'Thibault',
                    'role' => 'commis',
                ],
                [
                    'id' => 7,
                    'email' => 'gisel106@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Gisèle',
                    'prenom' => 'Langlois',
                    'role' => 'admin',
                ],
                [
                    'id' => 8,
                    'email' => 'henry108@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Henry',
                    'prenom' => 'Bélanger',
                    'role' => 'responsable',
                ],
                [
                    'id' => 9,
                    'email' => 'isabelle109@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Isabelle',
                    'prenom' => 'Girard',
                    'role' => 'commis',
                ],
                [
                    'id' => 10,
                    'email' => 'jules110@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Jules',
                    'prenom' => 'Lefebvre',
                    'role' => 'admin',
                ],
                [
                    'id' => 11,
                    'email' => 'karine111@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Karine',
                    'prenom' => 'Néron',
                    'role' => 'responsable',
                ],
                [
                    'id' => 12,
                    'email' => 'leo112@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Léo',
                    'prenom' => 'Fortin',
                    'role' => 'commis',
                ],
                [
                    'id' => 13,
                    'email' => 'marie113@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Marie',
                    'prenom' => 'Bourget',
                    'role' => 'admin',
                ],
                [
                    'id' => 14,
                    'email' => 'nicolas114@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Nicolas',
                    'prenom' => 'Barbeau',
                    'role' => 'responsable',
                ],
                [
                    'id' => 15,
                    'email' => 'olga115@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Olga',
                    'prenom' => 'Boucher',
                    'role' => 'commis',
                ],
                [
                    'id' => 16,
                    'email' => 'pierre116@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Pierre',
                    'prenom' => 'Desjardins',
                    'role' => 'admin',
                ],
                [
                    'id' => 17,
                    'email' => 'quebec117@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Quebec',
                    'prenom' => 'Lévesque',
                    'role' => 'responsable',
                ],
                [
                    'id' => 18,
                    'email' => 'renee118@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Renée',
                    'prenom' => 'Dumont',
                    'role' => 'commis',
                ],
                [
                    'id' => 19,
                    'email' => 'sophie119@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Sophie',
                    'prenom' => 'Roy',
                    'role' => 'admin',
                ],
                [
                    'id' => 20,
                    'email' => 'theo120@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Théo',
                    'prenom' => 'Lavoie',
                    'role' => 'responsable',
                ],
                [
                    'id' => 21,
                    'email' => 'vicky121@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Vicky',
                    'prenom' => 'Dufour',
                    'role' => 'commis',
                ],
                [
                    'id' => 22,
                    'email' => 'william122@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'William',
                    'prenom' => 'Langlois',
                    'role' => 'admin',
                ],
                [
                    'id' => 23,
                    'email' => 'xavier123@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Xavier',
                    'prenom' => 'Lemoine',
                    'role' => 'responsable',
                ],
                [
                    'id' => 24,
                    'email' => 'yasmine124@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Yasmine',
                    'prenom' => 'Charest',
                    'role' => 'commis',
                ],
                [
                    'id' => 25,
                    'email' => 'zachary125@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Zachary',
                    'prenom' => 'Fortier',
                    'role' => 'admin',
                ],
                [
                    'id' => 26,
                    'email' => 'anna126@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Anna',
                    'prenom' => 'Thibault',
                    'role' => 'responsable',
                ],
                [
                    'id' => 27,
                    'email' => 'brian127@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Brian',
                    'prenom' => 'Savoie',
                    'role' => 'commis',
                ],
                [
                    'id' => 28,
                    'email' => 'cathy128@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Cathy',
                    'prenom' => 'Nicolas',
                    'role' => 'admin',
                ],
                [
                    'id' => 29,
                    'email' => 'daniel129@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Daniel',
                    'prenom' => 'Dufresne',
                    'role' => 'responsable',
                ],
                [
                    'id' => 30,
                    'email' => 'elaine130@example.com',
                    'password' => Hash::make('password'),
                    'nom' => 'Elaine',
                    'prenom' => 'Picard',
                    'role' => 'commis',
                ],
            ]
        );
}
}