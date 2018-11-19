<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriquecongeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historiqueConge', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->time('heure_sortie')->nullable();
            $table->unsignedInteger('duree')->nullable(); 
            $table->string('motif');
            $table->date('date_reprise');
            $table->time('heure_reprise');
            $table->string('etat');
            $table->string('remarque')->nullable();
            $table->timestamps();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historiqueConge');
    }
}
