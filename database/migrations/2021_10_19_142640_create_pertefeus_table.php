<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePertefeusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pertefeus', function (Blueprint $table) {
            $table->bigIncrements('pertefeu_id')->unique();
            $table->float('masse_creuse',8,2);
            $table->float('masse_initiale',8,2);
            $table->float('masse_2h', 8, 2);
            $table->float('temperature',8,2);
            $table->dateTime('created_at');

        });


        Schema::table('pertefeus', function($table)
        {
            $table->string('reference_labo')->nullable();
            $table->foreign('reference_labo')
                        ->references('reference_labo')
                        ->on('echantillons')
                        ->onDelete('cascade')
                        ->onUpdate('cascade')
                        ->nullable(); 
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pertefeus');
    }
}
