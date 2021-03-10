<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AtelierHoraire extends Model
{
    protected $table = 'atelier_horaires';

    public function professeur(){
        return $this->belongsTo('App\Professeur');
    }

    public function bloc(){
        return $this->belongsTo('App\Bloc');
    }

    public function atelier_inscriptions(){
        return $this->hasMany('App\AtelierInscription');
    }
}
