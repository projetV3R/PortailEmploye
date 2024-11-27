<?php
// App/Observers/FinanceObserver.php

namespace App\Observers;

use App\Models\Finance;
use App\Models\Historique;

use Illuminate\Support\Facades\Auth;
use App\Notifications\NotificationModification;
class FinanceObserver
{
    //TODO Update pour lisibilité et fonction a refacto
    public function updating(Finance $finance)
    {
        $historique = new Historique();
        $historique->table_name = $finance->getTable();
        $historique->author = $fournisseur->adresse_courriel;
        $historique->action = 'Modifier';

       
        $newValues = [];
        foreach ($finance->getDirty() as $key => $value) {
            $newValues[] = "+$key: $value";
        }
        $historique->new_values = implode(", ", $newValues); 

  
        $originalValues = [];
        foreach ($finance->getDirty() as $key => $value) {
            $originalValues[] = "-$key: " . $finance->getOriginal($key);
        }
        $historique->old_values = implode(", ", $originalValues); // Convertit en chaîne lisible

        $historique->fiche_fournisseur_id = $finance->fiche_fournisseur_id;
        $historique->save();
        $sectionModifiee = 'Finance';
        $data = [
        'sectionModifiee' => $sectionModifiee,
        'nomEntreprise' => $fournisseur->nom_entreprise,
        'emailEntreprise' => $fournisseur->adresse_courriel,
        'dateModification' => now()->format('d-m-Y H:i:s'),
        'auteur' => $fournisseur->adresse_courriel,
    ];
    $fournisseur->notify(new NotificationModification($data));
    }
}

