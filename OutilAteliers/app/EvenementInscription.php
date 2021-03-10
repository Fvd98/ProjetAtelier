<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvenementInscription extends Model
{
    protected $table = 'evenement_inscriptions';

    public function evenement(){
        return $this->belongsTo('App\Evenement');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}