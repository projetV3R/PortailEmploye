<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use Laravel\Sanctum\HasApiTokens;


class Usager extends Authenticatable
{
    use HasFactory,Notifiable;
    protected $table = 'usagers';

    protected $fillable = [
        'email',
        'password',
        'nom',
        'prenom',
        'role',
    ];
    public function hasRole($role)
    {
        return $this->role === $role;
    }
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
