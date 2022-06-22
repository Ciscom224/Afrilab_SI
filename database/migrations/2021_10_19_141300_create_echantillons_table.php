<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEchantillonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('echantillons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('designation');
            $table->string('reference_labo')->unique();
            $table->text('elements_d_analyse');
            $table->float('masse_pc', 8, 5)->default(0);
            $table->float('vid',8,5)->default(0);
            $table->float('pd',8,5)->default(0);
            $table->float('vol_pc',8,5)->default(0);
            $table->integer('pc')->default(0);
            $table->integer('pm')->default(0);



            $table->dateTime('created_at');
            Schema::enableForeignKeyConstraints();
        });

        Schema::table('echantillons', function($table)
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
        Schema::disableForeignKeyConstraints();
        // $table->dropForeign('demande_id');
        // $table->dropForeign('pertefeu_id');
        // $table->dropForeign('densite_id');
        // $table->dropForeign('humidite_id');
        // $table->dropForeign('volumetrie_id');
        Schema::dropIfExists('echantillons');
    }
}
