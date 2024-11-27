<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class FicheFournisseur extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        "neq",
        "etat",
        "password",
        "nom_entreprise",
        "adresse_courriel",
        "details_specifications",
        "date_changement_etat",
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function routeNotificationForMail($notification)
    {
        return $this->adresse_courriel;
    }

    public function licence()
    {
        return $this->hasOne(Licence::class);
    }

    public function coordonnees()
    {
        return $this->hasOne(Coordonnee::class);
    }

    public function finance()
    {
        return $this->hasOne(Finance::class);
    }
    public function brochuresCarte()
    {
        return $this->hasMany(BrochureCarte::class, 'fiche_fournisseur_id');
    }

    public function produitsServices()
    {
        return $this->belongsToMany(
            ProduitsServices::class,
            'produit_service_fiche_fournisseur',
            'fiche_fournisseur_id',
            'produit_service_id'
        );
    }
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
    public function coordonnee()
    {
        return $this->hasOne(Coordonnee::class);
    }


    /**
     * Retrouve le mot de passe de l'usager.
     * Nécessaire pour l'authentification puisque Laravel a besoin d'un champ qui s'appelle password.
     * @return string
     */
}
