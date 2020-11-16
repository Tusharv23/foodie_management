<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $now;
    protected $response;

    public function __construct()
    {
        $this->now = Carbon::now()->toDateTimeString();
        $this->response = [
            'data'=>null,
            'error'=>null,
            'code'=>200
        ];
    }
}
