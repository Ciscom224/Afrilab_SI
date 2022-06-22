<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolumetriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volumetries', function (Blueprint $table) {
            $table->bigIncrements('volumetrie_id')->unique();
            $table->float('vol_edta',8,5);
            $table->dateTime('created_at');



       
        });

        Schema::table('volumetries', function($table)
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
        Schema::dropIfExists('volumetries');
    }
}
