<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParametreSysteme;

class ParametreSystemeSeeder extends Seeder
{
    public function run()
    {
        ParametreSysteme::updateOrCreate(
            ['cle' => 'email_approvisionnement'],
            ['valeur' => 'approvisionnement@v3r.net']
        );

        ParametreSysteme::updateOrCreate(
            ['cle' => 'finance_approvisionnement'],
            ['valeur' => 'finances@v3r.net']
        );

        ParametreSysteme::updateOrCreate(
            ['cle' => 'taille_fichier'],
            ['valeur_numerique' => '75']
        );

        ParametreSysteme::updateOrCreate(
            ['cle' => 'mois_revision'],
            ['valeur_numerique' => '24']
        );
    }
}

