<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    public function departement(){
        return $this->belongsTo('App\Departement');
    }

    public function user(){
        return $this->hasOne('App\User');
    }

    public function atelier_horaires(){
        return $this->hasMany('App\AtelierHoraire');
    }
}