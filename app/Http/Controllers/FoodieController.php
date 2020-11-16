<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Foodie;

class FoodieController extends Controller
{
    public function getFoodieList(Request $request)
    {

    }

    public function getFoodie(Request $request, $id)
    {

    }

    public function getSimilarFoodie(Request $request, $id)
    {
        $foodieExists = Foodie::find($id);

        if(!$foodieExists) {
            $this->response['error'] = 'This foodie Id doesnot exists';
            return $this->response;
        }

        $this->response['data'] = Foodie::getSimilarFoodie($id,$foodieExists->favourite_food_id);

        return $this->response;
    }

    public function getSimilarRestaurant(Request $request, $id)
    {
        $foodieExists = Foodie::find($id);

        if(!$foodieExists) {
            $this->response['error'] = 'This foodie Id doesnot exists';
            return $this->response;
        }
        
        $restaurantsByFavFood = Foodie::restaurantByFavFood($foodieExists->favourite_food_id,$id);

        $this->response['data'] = $restaurantsByFavFood;

        return $this->response;
    }
}
