<?php
// App/Observers/FinanceObserver.php

namespace App\Observers;

use App\Models\Finance;
use App\Models\Historique;
use App\Models\FicheFournisseur;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NotificationModification;
class FinanceObserver
{
    //TODO Update pour lisibilité et fonction a refacto
    public function updating(Finance $finance)
    { $usager = Auth::user();
        $historique = new Historique();
        $historique->table_name = $finance->getTable();
        $historique->author = $usager->email;
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
        $fournisseur = FicheFournisseur::find($finance->fiche_fournisseur_id);
        $sectionModifiee = 'Finance';
        $data = [
        'sectionModifiee' => $sectionModifiee,
        'nomEntreprise' => $fournisseur->nom_entreprise,
        'emailEntreprise' => $fournisseur->adresse_courriel,
        'dateModification' => now()->format('d-m-Y H:i:s'),
    ];
    $fournisseur->notify(new NotificationModification($data));
    }
}

