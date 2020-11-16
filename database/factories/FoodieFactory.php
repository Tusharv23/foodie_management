<?php

namespace Database\Factories;

use App\Models\Foodie;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Foodie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $foodArray = \App\Models\Food::all()->pluck('id');
        return [
            'name'=>$this->faker->name,
            'date_of_birth'=>$this->faker->dateTimeBetween($startDate = '-25 years', $endDate = '-15 years'),
            'gender'=>$this->faker->randomElement(['male','female']),
            'favourite_food_id'=>$this->faker->randomElement($foodArray)
        ];
    }
}
