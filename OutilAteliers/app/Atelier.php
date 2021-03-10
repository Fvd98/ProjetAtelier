<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atelier extends Model
{
    public function atelier_horaires(){
        return $this->hasMany('App\AtelierHoraire');
    }
}
