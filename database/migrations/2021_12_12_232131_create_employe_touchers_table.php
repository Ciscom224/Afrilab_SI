<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeTouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employe_touchers', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_modif');
        });
        Schema::table('employe_touchers', function($table)
        {
            //les cles etrangeres...
            $table->string('employe_id');
            $table->foreign('employe_id')
                        ->references('matricule')
                        ->on('employes')
                        ->onDelete('cascade')
                        ;
            $table->string('demande_id');
            $table->foreign('demande_id')
                        ->references('demande_id')
                        ->on('demandes')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');

            Schema::enableForeignKeyConstraints();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employe_touchers');
    }
}
