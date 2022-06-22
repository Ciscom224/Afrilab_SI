<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('lecture',8,5);
          
            $table->string('reference_labo');
            $table->integer('code_element');
        });
        // Schema::table('aas', function($table)
        // {
        //     $table->string('reference_labo');
        //     $table->foreign('reference_labo')
        //                 ->references('reference_labo')
        //                 ->on('echantillons')
        //                 ->onDelete('cascade')
        //                 ->onUpdate('cascade');

        //     $table->integer('code_element');
        //     $table->foreign('code_element')
        //                 ->references('id')
        //                 ->on('elements')
        //                 ->onDelete('cascade')
        //                 ->onUpdate('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aas');
    }
}
