<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampledsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sampleds', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->float('masse',8,5);
            $table->float('volume',8,5);
            $table->timestamps();
        });
        Schema::table('sampleds', function($table)
        {
            $table->string('demande_id');
            $table->foreign('demande_id')
                        ->references('demande_id')
                        ->on('demandes')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');

            $table->integer('temoin_id');
            $table->foreign('temoin_id')
                        ->references('temoin_id')
                        ->on('temoin_volums')
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
        Schema::dropIfExists('sampleds');
    }
}
