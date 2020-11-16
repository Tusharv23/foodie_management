<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foodie extends Model
{
    use HasFactory;

    protected $fillable = ['name','score','date_of_birth','gender','favourite_food'];
    protected $visible = ['name','score','date_of_birth','gender','favourite_food'];

    public static function restaurantByFavFood($food,$id)
    {
        $alreadyVisited = \DB::table('foodie_restaurant_mapping')
        ->where('foodie_id',$id)
        ->get()
        ->pluck('restaurant_id');
        $food = \DB::table('food')
                ->where('id',$food)
                ->first();
        return \DB::table('food')
                    ->where(function($query) use($food){
                        $query->where('food.name','like',$food->name)
                                ->orWhere('food.cuisine','like',$food->cuisine);
                    })
                    ->join('food_restaurant_mapping','food.id','=','food_restaurant_mapping.food_id')
                    ->join('restaurants','food_restaurant_mapping.restaurant_id','=','restaurants.id')
                    ->whereNotIn('food_restaurant_mapping.restaurant_id',$alreadyVisited)
                    ->select('restaurants.*')
                    ->get();
    }

    public static function getSimilarFoodie($id,$foodId)
    {
        $total = [];
        $similarFavouriteFood = \DB::table('foodies')
                                    ->where('id','!=',$id)
                                    ->where('favourite_food_id',$foodId)
                                    ->get()->toArray();
        //As data set increases.
        //$similarFoodieByCuisine = [];
        //$similarFoodieByRestaurantsVisited = [];
        //$similarFoodieByRestaurantsVisitedAndThereRatings = [];
        
        return array_merge($total,$similarFavouriteFood);
    }

}
