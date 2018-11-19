<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // relation avec la table Equipe
    public function equipe()
    {
        return $this->belongsTo('App\Equipe');
    }   

    // relation avec la table Conge
    public function conge()
    {
        return $this->hasMany('App\Conge');
    }

     // relation avec la table Historique Conge
     public function historiqueConge()
     {
         return $this->hasMany('App\Conge');
     }
}
