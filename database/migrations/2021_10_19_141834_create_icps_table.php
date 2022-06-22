<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIcpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icps', function (Blueprint $table) {
            $table->unsignedBigInteger('icp_id',true)->unique();
            $table->string('Al2O3_p',15)->default(0);
            $table->string('CaO_p',15)->default(0);
            $table->string('Fe2O3_p',15)->default(0);
            $table->string('K2O_p',15)->default(0);
            $table->string('MgO_p',15)->default(0);
            $table->string('MnO_p',15)->default(0);
            $table->string('P2O5_p',15)->default(0);
            $table->string('S_p',15)->default(0);
            $table->string('ASiO2_p',15)->default(0);
            $table->string('TiO2_p',15)->default(0);
            $table->string('As_ppm',15)->default(0);
            $table->string('B_ppm',15)->default(0);
            $table->string('Ba_ppm',15)->default(0);
            $table->string('Be_ppm',15)->default(0);
            $table->string('Bi_ppm',15)->default(0);
            $table->string('Cd_ppm',15)->default(0);
            $table->string('Co_ppm',15)->default(0);
            $table->string('Cr_ppm',15)->default(0);
            $table->string('Cu_ppm',15)->default(0);
            $table->string('Ge_ppm',15)->default(0);
            $table->string('Li_ppm',15)->default(0);
            $table->string('Mo_ppm',15)->default(0);
            $table->string('Ni_ppm',15)->default(0);
            $table->string('Pb_ppm',15)->default(0);
            $table->string('Sb_ppm',15)->default(0);
            $table->string('Se_ppm',15)->default(0);
            $table->string('Sn_ppm',15)->default(0);
            $table->string('Sr_ppm',15)->default(0);
            $table->string('Ta_ppm',15)->default(0);
            $table->string('Y_ppm',15)->default(0);
            $table->string('Zn_ppm',15)->default(0);
            $table->dateTime('created_at');
        });
    Schema::table('icps', function($table)
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
        Schema::dropIfExists('icps');
    }
}
