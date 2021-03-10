<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AtelierInscription extends Model
{
    protected $table = 'atelier_inscriptions';

    public function atelier_horaire(){
        return $this->belongsTo('App\AtelierHoraire');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
