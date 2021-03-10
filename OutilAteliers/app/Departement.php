<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    public function professeurs(){
        return $this->hasMany('App\Professeur');
    }
}