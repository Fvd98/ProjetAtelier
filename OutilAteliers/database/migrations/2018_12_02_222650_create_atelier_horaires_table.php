<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtelierHorairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atelier_horaires', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('atelier_id');
            $table->integer('professeur_id');
            $table->integer('bloc_id');
            $table->integer('numero');
            $table->time('heure');
            $table->time('duration');
            $table->string('salle_local');
            $table->integer('nombrePlace');
            $table->boolean('isCanceled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atelier_horaires');
    }
}
