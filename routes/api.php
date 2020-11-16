<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//list of restaurants according to on going check-ins 
Route::get('/restaurants','App\Http\Controllers\RestaurantController@getRestaurantList');

//Restaurant info including current capacity or waitlist if number is in negative then it is running on waitlist
Route::get('/restaurants/{id}','App\Http\Controllers\RestaurantController@getRestaurant');

//below two apis are for simple check-in and check-out and on check-in generating waiting number 
//if restaurant is full 
//on check out event is fired to update the waitlist number of waitng members in cache and also 
//update the rating of restaurants in realtime check-outs
Route::post('/restaurants/{id}/checkin','App\Http\Controllers\RestaurantController@checkIn');
Route::post('/restaurants/{id}/checkout','App\Http\Controllers\RestaurantController@checkOut');

Route::get('/foodies','App\Http\Controllers\FoodieController@getFoodieList');
Route::get('/foodies/{id}','App\Http\Controllers\FoodieController@getFoodie');

//Api for similar foodie suggestions
Route::get('/foodies/{id}/similar','App\Http\Controllers\FoodieController@getSimilarFoodie');

//Api for similar restaurant suggestions
Route::get('/foodies/{id}/resturant/suggestion','App\Http\Controllers\FoodieController@getSimilarRestaurant');
