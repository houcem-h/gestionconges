<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    // relation avec la table User
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
