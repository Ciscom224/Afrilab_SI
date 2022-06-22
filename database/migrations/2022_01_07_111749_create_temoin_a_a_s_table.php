<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemoinAASTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temoin_a_a_s', function (Blueprint $table) {
            $table->id();
            $table->float('lecture',8,5);
            $table->float('teneur_certif',8,5);
            $table->float('masse',8,5);
            $table->float('volume',8,5);
            $table->timestamps();
        });
        Schema::table('temoin_a_a_s', function($table)
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
        Schema::dropIfExists('temoin_a_a_s');
    }
}
