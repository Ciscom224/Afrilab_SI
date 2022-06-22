<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemoinVolumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temoin_volums', function (Blueprint $table) {
            $table->integer('temoin_id',true);
            $table->float('valeur',8,5);
            $table->float('masse',8,5);
            $table->float('volume',8,5);
            $table->timestamps();
        });
        Schema::table('temoin_volums', function($table)
        {
            $table->string('demande_id');
            $table->foreign('demande_id')
                        ->references('demande_id')
                        ->on('demandes')
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
        Schema::dropIfExists('temoin_volums');
    }
}
