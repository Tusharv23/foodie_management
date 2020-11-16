<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Restaurant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->streetName,
            'main_cuisine'=>$this->faker->randomElement(['Afghani',
            'African',
            'American',
            'Andhra',
            'Arabian']),
            'type'=>$this->faker->randomElement(['veg','non veg']),
            'locality'=>$this->faker->secondaryAddress,
            'city'=>$this->faker->city,
            'state'=>$this->faker->state,
            'ambience'=>$this->faker->randomElement(['lounge','bar','cafe','fine dine','club']),
            'capacity'=>$this->faker->randomElement([4,7,8,9,10,14])
        ];
    }
}
