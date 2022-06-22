<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalyseIcpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analyse_icps', function (Blueprint $table) {
            $table->string('element',15);
            $table->string('result',10);
            $table->timestamps();
        });
        Schema::table('analyse_icps', function($table)
        {
            $table->string('reference_labo');
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
        Schema::dropIfExists('analyse_icps');
    }
}
