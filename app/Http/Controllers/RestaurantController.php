<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Foodie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class RestaurantController extends Controller
{
    public function getRestaurantList(Request $request)
    {
        $filters = $request->filters;
        
        $restaurantListByCheckIn = Restaurant::restaurantListByCheckIn();

        $restaurantModel = Restaurant::whereIn('id',$restaurantListByCheckIn)
                                        ->orderByRaw(\DB::raw("FIELD(id, ".implode($restaurantListByCheckIn->toArray(),',')." )"));

        $this->response['data'] = $this->filteredRestaurants($restaurantModel,$filters);

        return $this->response;
    }


    protected function filteredRestaurants($model, $filters)
    {
        if(isset($filters) && $filters != null) {
            foreach($filters as $key => $value) {
                $model = $model->where($key,$value);
            }
        }
        
        $model = $model->get();
        $model = $model->sortBy(function($product){
            return $product->current_capacity;
        });
        return $model;
    }

    public function getRestaurant(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);
        
        if($restaurant === null) {
            $this->response['error'] = 'Invalid Restaurant Id';
            return $this->response;
        }
        
        $restaurant->current_capacity = Restaurant::getCurrentCapacity($id);//-ve value indicates waiting number
        $this->response['data'] = $restaurant;
        
        return $this->response;
    }

    public function checkIn(Request $request,$id)
    {
        $foodieId = $request->foodie_id;
        $foodie = Foodie::find($foodieId);
        
        if(isset($foodieId) && $foodie == null) {
            $this->response['error'] = 'Invalid foodie Id';
            return $this->response;
        }

        $restaurant = Restaurant::find($id);
        
        if($restaurant === null) {
            $this->response['error'] = 'Invalid Restaurant Id';
            return $this->response;
        }

        if(Restaurant::isAlreadyCheckedIn($id,$foodieId)) {
            $this->response['error'] = 'User Already checkedIn';
            return $this->response;
        }

        $status = Restaurant::checkIn($id,$foodieId,$this->now);
        
        if($status < 0) {
            $this->response['data']['waitlist'] = $status;
            Redis::set($id.':waitlist:'.$foodieId,$status);
        } else {
            $this->response['data']['waitlist'] = 0;
        }
        
        return $this->response;
    }

    public function checkOut(Request $request, $id)
    {
        $foodieId = $request->foodie_id;
        $foodie = Foodie::find($foodieId);
        
        if(isset($foodieId) && $foodie == null) {
            $this->response['error'] = 'Invalid foodie Id';
            return $this->response;
        }

        $restaurant = Restaurant::find($id);
        
        if($restaurant === null) {
            $this->response['error'] = 'Invalid Restaurant Id';
            return $this->response;
        }

        if(!Restaurant::isAlreadyCheckedIn($id,$foodieId)) {
            $this->response['error'] = 'User Never Checked In';
            return $this->response;
        }

        $rating = $request->rating != null ? $request->rating : null;
        $comment = $request->comment != null ? $request->comment : null;
        $status = Restaurant::checkOut($foodieId,$id,$this->now,$rating,$comment);
        
        if($status)
        \App\Jobs\Checkout::dispatch([
            'comment'=>$comment,
            'rating'=>$rating,
            'restaurant_id'=>$id,
            'foodie_id'=>$foodieId
            ]);

        $this->response['data'] = $status;
        return $this->response;
    }
}
