<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Restaurant::factory(20)->create();
    }
}
