<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    protected $fillable = ['name','rating','main_cuisine','type','locality','city','state','ambience','capacity'];
    protected $visible = ['name','rating','main_cuisine','type','locality','city','state','ambience','capacity','current_capacity'];

    public static function getCurrentCapacity($id)
    {
        $currentCheckins = \DB::table('foodie_restaurant_mapping')
                                ->where('restaurant_id',$id)
                                ->whereNull('check_out')
                                ->count();
        $capacity = \DB::table('restaurants')->where('id',$id)->first()->capacity;
        return $capacity - $currentCheckins;
    
    }

    public static function checkIn($restaurantId,$foodieId,$checkIn)
    {
        $current_capacity = Restaurant::getCurrentCapacity($restaurantId);
        \DB::table('foodie_restaurant_mapping')
            ->insert([
                'foodie_id'=>$foodieId,
                'restaurant_id'=>$restaurantId,
                'check_in'=>$checkIn
            ]);
        return $current_capacity - 1;
    }

    public static function checkOut( $foodieId,$restaurantId,$checkOut,$rating = null,$comment=null)
    {
        return \DB::table('foodie_restaurant_mapping')
                    ->where('foodie_id',$foodieId)
                    ->where('restaurant_id',$restaurantId)
                    ->whereNull('check_out')
                    ->update([
                        'check_out'=>$checkOut,
                        'rating'=>$rating,
                        'comment'=>$comment
                    ]);
    }

    public static function isAlreadyCheckedIn($restaurantId,$foodieId) 
    {
        return \DB::table('foodie_restaurant_mapping')
                ->where('foodie_id',$foodieId)
                ->where('restaurant_id',$restaurantId)
                ->whereNull('check_out')
                ->exists();
    }
    
    protected function restaurantListByCheckIn()
    {
        return \DB::table('foodie_restaurant_mapping')
                        ->select('restaurant_id',\DB::raw('count(*) as total'))
                        ->whereNull('check_out')
                        ->groupBy('restaurant_id')
                        ->orderBy('total','desc')
                        ->get()
                        ->pluck('restaurant_id');
    }
}
