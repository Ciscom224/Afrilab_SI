<?php

namespace Database\Factories;

use App\Models\echantillons;
use Illuminate\Database\Eloquent\Factories\Factory;

class echantillonsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = echantillons::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tab=[
            'Ag','Zn','Pb','Cu','Co','Ni','Al3O2','Ag','Al','Mn'
        ];
        return [
            'designation'=>$this->faker->regexify('[A-Za-z]{1}[0-4]{3}'),
            'reference_labo'=>$this->faker->numerify('R/2021_####'),
            'elements_d_analyse'=>$this->faker->randomElement($tab),
            'demande_id'=>123,
            'created_at'=>new \DateTime(),
        ];
    }
}
