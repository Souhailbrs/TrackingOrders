<?php

namespace App\Http\Controllers\Supporter;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderTrack;
use App\Models\SalesChannels;
use App\Models\Zone;
use App\WorkDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function trackOrder($id){
        $user_id =  Auth::guard('supporter')->user()->id;
        $records = OrderTrack::where('sales_channele_order',$id)->get();

        //Today State
        $today_work_days = WorkDay::where('user_type','supporter')->where('user_id',$user_id)->where('completed',0)->get();
        if(count($today_work_days )> 0){
            $today_work =1;
        }else {
            $today_work =0;
        }
        return view('supporter.orders.tarck',compact('records','id','today_work'));
    }
    public function home(){
        $user_id =  Auth::guard('supporter')->user()->id;
        $work_days = WorkDay::where('user_type','supporter')->where('user_id',$user_id)->get()->reverse();
        $records = $work_days;

        //Today State
        $today_work_days = WorkDay::where('user_type','supporter')->where('user_id',$user_id)->where('completed',0)->get();
        if(count($today_work_days )> 0){
            $today_work =1;
        }else {
            $today_work =0;
        }
        return view('supporter.home',compact('records','today_work'));
    }
    public function workState($state){
        $user_id =  Auth::guard('supporter')->user()->id;

        switch($state){
            case 'start':
                $work_days = WorkDay::where('user_type','supporter')->where('user_id',$user_id)->where('completed',0)->get();
                if(count($work_days )> 0){
                    return redirect()->back()->with('error','End Your day before start new one');
                }else{
                    WorkDay::create([
                       'user_type'=>'supporter',
                        'user_id'=>$user_id,
                        'started_at'=>date('y-m-d H:i:s'),
                        'completed'=>0,
                        'finished_at'=>date('y-m-d H:i:s'),
                    ]);
                    return redirect()->back()->with('success','You Have Started Your Day!');
                }
                break;
            case 'end':
                $work_days = WorkDay::where('user_type','supporter')->where('user_id',$user_id)->where('completed',0)->get();
                if(count($work_days )> 0){
                    foreach($work_days as $wo){
                        $wo->update([
                            'completed'=>1,
                            'finished_at'=>date('y-m-d H:i:s'),
                        ]);
                    }
                    return redirect()->back()->with('success','You Have Finished Your Day!');
                }else{
                    return redirect()->back()->with('error','You Have To Start Your Day');
                }
                break;
        }
    }
    public function sad(Request $request){
        if($request->state){
           return $this->workState('start');
        }else{
            return $this->workState('end');
        }
    }

}
