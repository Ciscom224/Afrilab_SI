<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDensitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('densites', function (Blueprint $table) {
            $table->bigIncrements('densite_id')->unique();
            $table->float('vol_v1',8,2);
            $table->float('vol_initial', 8, 2);
            $table->float('masse', 8, 2);
            $table->dateTime('created_at');
        });

        Schema::table('densites', function($table)
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
        Schema::dropIfExists('densites');
    }
}
