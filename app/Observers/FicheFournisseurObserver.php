<?php

namespace App\Observers;

use App\Models\FicheFournisseur;
use App\Models\Historique;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NotificationModification;
class FicheFournisseurObserver
{
    public function updated(FicheFournisseur $fournisseur)
    {
        $changes = $fournisseur->getChanges(); 
        $original = $fournisseur->getOriginal(); 

        $oldValues = [];
        $newValues = [];

     
        $attributesToCheck = ['adresse_courriel', 'neq', 'nom_entreprise'];
        foreach ($attributesToCheck as $attribute) {
            if (array_key_exists($attribute, $changes)) {
                $oldValues[] = "-{$attribute}: {$original[$attribute]}";
                $newValues[] = "+{$attribute}: {$fournisseur->$attribute}";
            }
        }

      
        if (array_key_exists('password', $changes)) {
            $oldValues[] = "-Mot de passe: [Masqué]";
            $newValues[] = "+Mot de passe: [Masqué]";
        }

     
        if (!empty($oldValues) || !empty($newValues)) {
            Historique::create([
                'table_name' => 'FicheFournisseur',
                'author' => $fournisseur->adresse_courriel,
                'action' => 'Modifier',
                'old_values' => !empty($oldValues) ? implode(", ", $oldValues) : null,
                'new_values' => !empty($newValues) ? implode(", ", $newValues) : null,
                'fiche_fournisseur_id' => $fournisseur->id,
            ]);
            $sectionModifiee = 'Identification et statut';
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
}
