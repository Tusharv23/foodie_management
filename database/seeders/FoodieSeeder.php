<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FoodieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Foodie::factory(20)->create();
    }
}
