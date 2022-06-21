<?php

namespace App\Http\Controllers\Delivery;

use App\Events\OrderState;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\ProductSeller;
use App\Models\Seller;
use App\WorkDay;
use App\WorkDayOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function home($filter){
        $user =Auth::guard('delivery')->user();
        $user_id =  Auth::guard('delivery')->user()->id;
        $work_days = WorkDay::where('user_type','delivery')->where('user_id',$user_id)->get()->reverse();
        $records = $work_days;

        //Today State
        $today_work_days = WorkDay::where('user_type','delivery')->where('user_id',$user_id)->where('completed',0)->get();
        if(count($today_work_days )> 0){
            $today_work =1;
        }else {
            $today_work =0;
        }

        $order_day = WorkDayOrder::where('userType','delivery')->where('userID',$user_id)->get();
        $orders= [];
         foreach($order_day as $one_day){

             if($filter == 'today'){
                 if( $one_day->order->status == 8){
                     if( $one_day->order->zone->id == $user->zone_id) {
                         $orders [] = $one_day->order;
                     }
                 }
             }elseif($filter == 'finishedToday'){

                 if( $one_day->order->status != 8 && date('Y-m-d',strtotime ($one_day->order->delivery_date))  == date('Y-m-d')){
                     if( $one_day->order->zone->id == $user->zone_id) {
                         $orders [] = $one_day->order;
                     }
                 }
             }elseif($filter == 'yesterday') {

                 if( date('Y-m-d',strtotime ($one_day->order->delivery_date))  == date('Y-m-d',strtotime(' - 1 days'))){
                     if( $one_day->order->zone->id == $user->zone_id) {
                         $orders [] = $one_day->order;
                     }
                 }
             }else{
                 if( $one_day->order->status != 8 && $one_day->order->delivery_date != Carbon::today()){
                     if( $one_day->order->zone->id == $user->zone_id) {
                         $orders [] = $one_day->order;
                     }
                 }
             }
         }
        $orders = array_unique($orders);

        return view('delivery.home',compact('records','today_work','filter','orders'));
    }
    public function workState($state){
        $user_id =  Auth::guard('delivery')->user()->id;

        switch($state){
            case 'start':
                $work_days = WorkDay::where('user_type','delivery')->where('user_id',$user_id)->where('completed',0)->get();
                if(count($work_days )> 0){
                    return redirect()->back()->with('error','End Your day before start new one');
                }else{
                    WorkDay::create([
                        'user_type'=>'delivery',
                        'user_id'=>$user_id,
                        'started_at'=>date('y-m-d H:i:s'),
                        'completed'=>0,
                        'finished_at'=>date('y-m-d H:i:s'),
                    ]);
                    return redirect()->back()->with('success','You Have Started Your Day!');
                }
                break;
            case 'end':
                $work_days = WorkDay::where('user_type','delivery')->where('user_id',$user_id)->where('completed',0)->get();
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
    public function trackOrder($id){
        $user_id =  Auth::guard('delivery')->user()->id;
        $records = OrderTrack::where('sales_channele_order',$id)->get();

        //Today State
        $today_work_days = WorkDay::where('user_type','delivery')->where('user_id',$user_id)->where('completed',0)->get();
        if(count($today_work_days )> 0){
            $today_work =1;
        }else {
            $today_work =0;
        }
        return view('delivery.wrap.tarck',compact('records','id','today_work'));
    }
    public function change_order_state_post(Request $request){
        $order = $request->order_id;
        $new = intval($request->state);
        $current_order = Order::find($order);
        $old = intval($current_order->status);
        $current_order->update([
           'notes'=>$request->notes
        ]);
        return $this->change_order_state($order, $old, $new);
    }
    public function change_order_state($order,$old,$new){
        OrderState::broadcast($order,$old,$new);

        $real_order = Order::find($order);
        if($new == 10){
          $products =   $real_order->product;
          foreach($products as $pro){
              $product_id = ProductSeller::find($pro->product_id);
              $product_id->update([
                  'amount'=> intval($product_id->amount) - intval($pro->amount) ,
                  'sold'=>intval($product_id->sold) + intval($pro->amount) ,

              ]);
          }
        }
        $real_order->update([
            'status'=>$new
        ]);
        $user_id = Seller::where('email',$real_order->shop->owner_email)->first()->id;
        $this->ordeLog($user_id,$real_order->id,$new);

        return redirect()->back();
    }
}
