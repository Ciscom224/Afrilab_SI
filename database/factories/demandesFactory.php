<?php

namespace Database\Factories;

use App\Models\demandes;
use Illuminate\Database\Eloquent\Factories\Factory;

class demandesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = demandes::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tab= [
            'solide',
            'liquide',
            'pulpe'
        ];
        $eta_sol=[
            'minreai',
            'roche',
            'poudre'
        ];
        $etat=$this->faker->randomElement($tab);
        $etat_cur=null;
        if ($etat==='solide') {
            $etat_cur=$this->faker->randomElement($eta_sol);
        }
        return [
            'demande_id'=>$this->faker->randomNumber(5, true),
            'society'=>$this->faker->randomNumber(5, true),
            'identification_echantillon'=>$this->faker->randomElement($tab),
            'demandeur'=>$this->faker->company(),
            'etat'=>$this->faker->randomElement($tab),
            'etat_solid'=>$etat_cur,
            'echantillonnage'=>$this->faker->randomElement(['afrilab','client']),
            'depot'=>$this->faker->randomElement(['SSL','OPL']),
            'nombre_echantillons'=>$this->faker->randomNumber(5, true),
            'Emplacement'=>$this->faker->randomElement(['B345','C12']),
            'observation'=>$this->faker->text(),
            'livraison'=>$this->faker->city(),
            'created_at'=>new \DateTime(),

        ];
    }
}
