<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conge extends Model
{
    protected $table = 'conge';

    // relation avec la table User
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function historiqueConge()
    {
        return $this->hasOne('App\HistoriqueConge');
    }
}
