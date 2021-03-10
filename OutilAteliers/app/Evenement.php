<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    public function blocs(){
        return $this->hasMany('App\Bloc');
    }

    public function evenement_inscriptions(){
        return $this->hasMany('App\EvenementInscription');
    }
}