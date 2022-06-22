<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->string('demande_id')->unique();
            $table->string('society');
            $table->string('identification_echantillon');
            $table->string('demandeur');
            $table->string('etat');
            $table->string('etat_solid')->nullable();
            $table->string('echantillonnage');
            $table->string('depot')->nullable();
            $table->string('nombre_echantillons');
            $table->string('Emplacement');
            $table->string('observation')->default('vide');
            $table->string('livraison')->default('vide');
            $table->dateTime('created_at');
            $table->integer('niveau')->default(0);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        // $table->dropForeign('employe_id');
        // $table->dropForeign('aa_id');
        // $table->dropForeign('icp_id');
        Schema::drop('employes');
        Schema::dropIfExists('demandes');
    }
}
