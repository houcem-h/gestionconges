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
            $table->unsignedInteger('employee');
            $table->string('type');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->time('heure_sortie')->nullable();
            $table->unsignedInteger('duree')->nullable(); 
            $table->string('motif');
            $table->date('date_reprise');
            $table->time('heure_reprise');
            $table->unsignedInteger('valide_par');
            $table->timestamps();
            $table->foreign('employee')->references('created_by')->on('conge');
            $table->foreign('valide_par')->references('updated_by')->on('conge');
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
