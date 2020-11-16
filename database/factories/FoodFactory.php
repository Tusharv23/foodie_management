<?php

namespace Database\Factories;

use App\Models\Food;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Food::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->randomElement(['Egg',
            'Black Salt (Chemical)',
            'Garlic',
            'Onions',
            'Legumes',
            'Cabbage',
            'Brocolli',
            'Cauliflower',
            'Rubbery',
            'Natural Gas',
            'Burnt Match Stick']),
            'cuisine'=>$this->faker->randomElement(['Afghani',
            'African',
            'American',
            'Andhra',
            'Arabian']),
            'type'=>$this->faker->randomElement(['veg','non veg']),
            'spice_level'=>$this->faker->randomElement([1,2,3,4,5])
        ];
    }
}
