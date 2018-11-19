<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoriqueConge extends Model
{
    protected $table = 'historiqueconge';

    // relation avec la table User
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
}
