<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class CheckOut //implements ShouldQueue //it is commented right now to run on local while going live it should be uncommented
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $model;
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $keys = Redis::keys($this->model['restaurant_id'].':waitlist:*');
        foreach($keys as $key) {
            $count = Redis::get($key);
            if($count == -1) {
                Redis::del($key);
            } else {
                Redis::set($key,$count+1);
            }
        }

        $restaurants_rating = \DB::table('foodie_restaurant_mapping')
                                ->whereNotNull('rating')
                                ->where('restaurant_id',$this->model['restaurant_id'])
                                ->avg('rating');
        \App\Models\Restaurant::where('id',$this->model['restaurant_id'])
                                ->update([
                                    'rating'=>$restaurants_rating,
                                ]);
        $total_restaurant_visited = \DB::table('foodie_restaurant_mapping')
                                ->whereNotNull('rating')
                                ->where('foodie_id',$this->model['foodie_id'])
                                ->distinct('restaurant_id')
                                ->count();
        $total_restaurants =  \App\Models\Restaurant::count();
        $score = ($total_restaurant_visited/$total_restaurants)*100;
        $foodie_model = \App\Models\Foodie::where('id',$this->model['foodie_id']);
        $foodie_model->first->favourite_food_id
        $foodie_model->update([
            'score'=>$score
        ]);
    }
}
