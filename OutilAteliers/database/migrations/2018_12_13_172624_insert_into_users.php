<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use App\User;

class InsertIntoUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $User = new User;
        $User->nom = "Vermette";
        $User->prenom = "Francis";
        $User->courriel = "francis98@live.ca";
        $User->numero = "1620353";
        $User->motDePasse = Hash::make("Allo123");
        $User->isAdmin = true;
        $User->programme_id = 1;
        $User->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
