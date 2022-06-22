<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHumiditesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('humidites', function (Blueprint $table) {
            $table->bigIncrements('humidite_id')->unique();
            $table->float('poids_tar',8,2);
            $table->float('poids_humid',8,2);
            $table->float('poids_seche', 8, 2);
            $table->dateTime('created_at');




        });


        Schema::table('humidites', function($table)
        {
            $table->string('reference_labo')->nullable();
            $table->foreign('reference_labo')
                        ->references('reference_labo')
                        ->on('echantillons')
                        ->onDelete('cascade')
                        ->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('humidites');
    }
}
