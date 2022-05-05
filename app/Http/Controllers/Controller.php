<?php

namespace App\Http\Controllers;
use App\Models\OrderLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function ordeLog($seller_id,$order_id,$status){
        $log = OrderLog::create([
            'seller_id'=>$seller_id,
            'order_id'=>$order_id,
            'status'=>$status
        ]);
        if($log){
            return 1;
        }else{
            return 2;
        }

    }
}
