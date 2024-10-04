<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModeleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modeles')->insert([
            [
                'type' => 'Accusé de réception',
                'objet' => 'Accusé de réception',
                'body' => 'Nous avons bien reçu votre demande. Nous vous contacterons sous peu.',
                'actif' => true,
            ],
            [
                'type' => 'Votre demande a été acceptée',
                'objet' => 'Votre demande a été acceptée',
                'body' => 'Félicitations, votre demande a été acceptée.',
                'actif' => true,
            ],
            [
                'type' => 'Votre demande a été refusée',
                'objet' => 'Votre demande a été refusée',
                'body' => 'Nous sommes désolés, votre demande a été refusée.',
                'actif' => true,
            ],
            [
                'type' => 'Notification service approvisionnement',
                'objet' => 'Notification du service approvisionnement',
                'body' => 'Veuillez noter que le service approvisionnement a mis à jour ses conditions.',
                'actif' => true,
            ],
            [
                'type' => 'Courriel du service des finances',
                'objet' => 'Courriel du service des finances',
                'body' => 'Le service des finances vous informe d’une nouvelle mise à jour concernant vos transactions.',
                'actif' => true,
            ],
        ]);
    }
}
