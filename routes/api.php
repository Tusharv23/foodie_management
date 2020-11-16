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

Route::get('/restaurants','App\Http\Controllers\RestaurantController@getRestaurantList');//list of restaurants 
Route::get('/restaurants/{id}','App\Http\Controllers\RestaurantController@getRestaurant');

Route::post('/restaurants/{id}/checkin','App\Http\Controllers\RestaurantController@checkIn');
Route::post('/restaurants/{id}/checkout','App\Http\Controllers\RestaurantController@checkOut');

Route::get('/foodies','App\Http\Controllers\FoodieController@getFoodieList');
Route::get('/foodies/{id}','App\Http\Controllers\FoodieController@getFoodie');
Route::get('/foodies/{id}/similar','App\Http\Controllers\FoodieController@getSimilarFoodie');
Route::get('/foodies/{id}/resturant/suggestion','App\Http\Controllers\FoodieController@getSimilarRestaurant');
