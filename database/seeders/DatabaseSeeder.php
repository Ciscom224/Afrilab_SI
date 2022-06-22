<?php

namespace Database\Seeders;

use App\Models\demandes;
use App\Models\echantillons;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        demandes::factory(100)->create();
        echantillons::factory(50)->create();
    }
}
