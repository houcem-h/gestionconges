<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCongeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conge', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['Conge', 'Sortie']);
            $table->date('date_debut');
            $table->date('date_fin');
            $table->time('heure_sortie')->nullable();
            $table->unsignedInteger('duree')->nullable(); 
            $table->enum('motif', ['Affaire personnelle', 'Maladie', 'Maternité', 'Sans solde', 'Annuel']);
            $table->date('date_reprise');
            $table->time('heure_reprise');
            $table->enum('etat', ['En attente', 'Valide', 'Refus', 'Correction']);
            $table->string('remarque')->nullable();
            $table->timestamps();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
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
        Schema::dropIfExists('demande_conge');
    }
}
