<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bloc extends Model
{
    public function atelier_horaires(){
        return $this->hasMany('App\AtelierHoraire');
    }

    public function evenement(){
        return $this->belongsTo('App\Evenement');
    }
}
