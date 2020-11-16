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

    //below function fetches similar foodies 
    //on the basis of favourite food as data set 
    //increase we can get them on the basis of cuisine too 
    //and so on as written in model.
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

    //below function fetches similar restaurants on the basis of users favourite food and cuisine
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
