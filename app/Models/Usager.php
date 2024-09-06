<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\User;

class Usager extends Authenticatable
{
    use HasFactory,Notifiable;
    protected $fillable = [
        'email',
        'motDePasse',
        'nom',
        'prenom',
    ];
    protected $hidden = [
        'motDePasse',
        'remember_token',
    ];
}
