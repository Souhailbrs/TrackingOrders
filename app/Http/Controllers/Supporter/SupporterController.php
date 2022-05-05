<?php

namespace App\Http\Controllers\Supporter;

use App\Events\OrderState;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderContact;
use App\Models\SalesChannels;
use App\Models\Zone;
use App\WorkDay;
use App\WorkDayOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SupporterController extends Controller
{
    public function getOrder(){
        $user_id =  Auth::guard('supporter')->user()->id;
        $work_days = WorkDay::where('user_type','supporter')->where('user_id',$user_id)->where('completed',0)->get();
        //If supporter start work or not.
        if(count($work_days )> 0) {
            $data = $this->getNextOrder();
            $action = 'update';
            $page = 'orders';
            $pages = 'orders';
            //IS There available orders!
            if($data){
                if(!$this->IsUserHasOrder()){
                    //Take New Order
                    $data->update([
                        'status' => 1
                    ]);
                    OrderState::broadcast($data->id, $data->status, 1);
                    WorkDayOrder::create([
                        'user_user_work_day' => $work_days[0]->id,
                        'user_sales_channele_orders' => $data->id,
                        'order_status_from' => date('y-m-d H:i:s A'),
                        'order_status_to' => 0,
                        'userType' => 'supporter',
                        'userID' => $user_id,
                        'status' =>0
                    ]);

                    return $this->getCurrentOrder();

                    //return redirect()->back()->with('success','you successfully has added new order');
                }else{
                    return $this->getCurrentOrder();
                    //      return redirect()->back()->with('error','Finish your order first before taking a new one.');
                }
            }else{
                return $this->getCurrentOrder();

                //return redirect()->route('supporter.home')->with('error','There is no orders yet!');
            }
        }else{
            return redirect()->back()->with('error','You Have To Start Your Day');
        }
    }
    //If User Have Order Now "Available or not "
    public function IsUserHasOrder(){
        $user_id =  Auth::guard('supporter')->user()->id;
        $user_type = 'supporter';
        $orders = WorkDayOrder::where('userType',$user_type)->where('userID',$user_id)->where('status',0)->get();
        if(count($orders) > 0){
            return 1;
        }
        return 0;
    }
    public function getCurrentOrder(){
        $user_id =  Auth::guard('supporter')->user()->id;
        $user_email =  Auth::guard('supporter')->user()->email;

        $user_type = 'supporter';
        $orders = WorkDayOrder::where('userType',$user_type)->where('userID',$user_id)->where('status',0)->first();
        if($orders) {
            $order_id = $orders->user_sales_channele_orders;
            $data = Order::find($order_id);
            while($data->deleted != 0){
                $data = $this->getNextOrder();
            }
            $action = 'update';
            $page = 'orders';
            $pages = 'orders';
            $shopTypes = SalesChannels::find($data->sales_channel);
            $cities = City::get();
            $countries = Country::get();
            $zones = Zone::get();
            $shops = SalesChannels::where('owner_email', $user_email)->get();
            //Today State
            $today_work_days = WorkDay::where('user_type', 'supporter')->where('user_id', $user_id)->where('completed', 0)->get();
            if (count($today_work_days) > 0) {
                $today_work = 1;
            } else {
                $today_work = 0;
            }

            return view('supporter.orders.control', compact('data', 'action', 'page', 'pages', 'shopTypes', 'cities', 'countries', 'zones', 'shops', 'today_work'));
        }else{
            return redirect()->route('supporter.home')->with('error','You Dont Have any orders!');
        }
    }
    public function getAllOrders($state)
    {
        $user_id =  Auth::guard('supporter')->user()->id;
        $recordsx =[];
        if($state === 'today') {
            $recordsx = WorkDayOrder::where('userType', 'supporter')->where('userID', $user_id)->whereDate('created_at', Carbon::today())->get();
        }elseif($state === 'all'){
            $recordsx = WorkDayOrder::where('userType', 'supporter')->where('userID', $user_id)->get();
        }else{
            return  $state;
        }
        $records = [];
        foreach($recordsx as $recx){
            $records [] = $recx->order;
        }
        return view('supporter.orders.index',compact('records'));
    }
    public  function getNextOrder(){
        // No Answer Delivery.
        $No_Answer_Delivery = $this->No_Answer_Delivery_Orders();
        // Customer Cancelled Delivery
        //$Customer_Cancelled_callCenter= $this->Customer_Cancelled_callCenter();
        $Customer_Cancelled_callCenter =[];
        // Customer Cancelled Delivery
        $customer_cancelled_delivery = $this->Customer_Cancelled_Delivery();
        // Confirm Order at deliver day
        $Confirm_Order_at_deliver_day = $this->Confirm_Order_at_deliver_day();
        // New Orders
        $New_Orders = $this->New_Orders();
        // No Answer Call Center
        $No_Answer_Call_Center = $this->No_Answer_Call_Center();
        // Not Confirmed
        $Not_Confirmed = $this->Not_Confirmed();
        $res = array_merge($No_Answer_Delivery,$Customer_Cancelled_callCenter,$customer_cancelled_delivery,$Confirm_Order_at_deliver_day,$New_Orders,$No_Answer_Call_Center,$Not_Confirmed);
        if(count($res) > 0){
            return Order::find($res[0]);
        }else{
            return 0;
        }
    }
    // No Answer Delivery Orders.
    public  function  No_Answer_Delivery_Orders(){
        $user_id =  Auth::guard('supporter')->user()->id;
        $orders_no_answer_delivery = Order::where('status',12)->where('deleted',0)->get();
        $orders_no_answer_delivery_new = [];
        foreach($orders_no_answer_delivery as $record){
            $exist = OrderContact::where('status',12)->where('sale_channele_order_id',$record->id)->where('created_at', '>=', date('Y-m-d').' 00:00:00')->where('userType','supporter')->where('user_id',$user_id)->get();
            if (count($exist) < 2) {
                if (count($exist) < 1) {
                    $orders_no_answer_delivery_new [] = $record->id;
                } else {
                    if (date('Y-m-d-H:i:s', strtotime($exist[0]->updated_at)) < date('Y-m-d H:i:s', strtotime('-4 hours'))) {
                        $orders_no_answer_delivery_new [] = $record->id;
                    }
                }
            }


        }
        return $orders_no_answer_delivery_new;
    }
    // Customer Cancelled Delivery.
    public function  Customer_Cancelled_callCenter(){
        $user_id =  Auth::guard('supporter')->user()->id;

        $orders_no_answer_delivery = Order::where('status',6)->where('deleted',0)->get();
        $orders_no_answer_delivery_new = [];
        foreach($orders_no_answer_delivery as $record){
            $exist = OrderContact::where('status',6)->where('sale_channele_order_id',$record->id)->where('userType','supporter')->where('user_id',$user_id)->get();
            if(count($exist) <=  0){
                $orders_no_answer_delivery_new [] = $record->id;
            }
        }
        return $orders_no_answer_delivery_new;
    }
    // Customer Cancelled Delivery.
    public function  Customer_Cancelled_Delivery(){
        $user_id =  Auth::guard('supporter')->user()->id;

        $orders_no_answer_delivery = Order::where('status',11)->where('deleted',0)->get();
        $orders_no_answer_delivery_new = [];
        foreach($orders_no_answer_delivery as $record){
            $exist = OrderContact::where('status',11)->where('sale_channele_order_id',$record->id)->where('userType','supporter')->where('user_id',$user_id)->get();
            if(count($exist) <=  0){
                $orders_no_answer_delivery_new [] = $record->id;
            }
        }
        return $orders_no_answer_delivery_new;
    }
    // Confirm Order at deliver day
    public function  Confirm_Order_at_deliver_day(){
        $user_id =  Auth::guard('supporter')->user()->id;
        //Delivery date
        //Confirmed date
        $orders_no_answer_delivery = Order::where('status',4)->where('delivery_date','=', Carbon::today())->where('deleted',0)->get();
        $orders_no_answer_delivery_new = [];
        foreach($orders_no_answer_delivery as $record){
            $exist = OrderContact::where('status',4)->where('sale_channele_order_id',$record->id)->where('userType','supporter')->where('user_id',$user_id)->get();
            if(count($exist) > 0) {

                if (date('Y-m-d-H:i:s', strtotime($exist[0]->updated_at)) > date('Y-m-d H:i:s', strtotime('+36 hours'))) {
                    $orders_no_answer_delivery_new [] = $record->id;
                }
            }
            /*
              if(count($exist) < 1 ) {
                  $orders_no_answer_delivery_new [] = $record->id;
              }else{
                  if (date('Y-m-d-H:i:s',strtotime($exist[0]->updated_at)) < date('Y-m-d H:i:s', strtotime('-4 hours')) ){
                      $orders_no_answer_delivery_new [] = $record->id;
                  }
              }*/
        }
        return $orders_no_answer_delivery_new;
    }
    // New Orders.
    public function New_Orders(){

        $orders_no_answer_delivery = Order::where('status',0)->where('deleted',0)->get();
        $ids = [];
        foreach($orders_no_answer_delivery as $record){
            $ids [] = $record->id;
        }
        return $ids;
    }
    // No Answer Call Center
    public  function  No_Answer_Call_Center(){
        $user_id =  Auth::guard('supporter')->user()->id;
        $orders_no_answer_delivery = Order::where('status',2)->where('deleted',0)->get();
        $orders_no_answer_delivery_new = [];
        foreach($orders_no_answer_delivery as $record){
            $exist = OrderContact::where('status',2)->where('sale_channele_order_id',$record->id)->where('created_at', '>=', date('Y-m-d').' 00:00:00')->where('userType','supporter')->where('user_id',$user_id)->get();
            if(count($exist) < 2 ){
                if(count($exist) < 1 ) {
                    $orders_no_answer_delivery_new [] = $record->id;
                }else{
                    if (date('Y-m-d-H:i:s',strtotime($exist[0]->updated_at)) < date('Y-m-d H:i:s', strtotime('-1 minute')) ){
                        $orders_no_answer_delivery_new [] = $record->id;
                    }
                }
            }
        }
        return $orders_no_answer_delivery_new;
    }
    // Not Confirmed
    public  function  Not_Confirmed(){
        $user_id =  Auth::guard('supporter')->user()->id;
        $orders_no_answer_delivery = Order::where('status',5)->where('deleted',0)->get();
        $orders_no_answer_delivery_new = [];
        foreach($orders_no_answer_delivery as $record){
            $exist = OrderContact::where('status',5)->where('sale_channele_order_id',$record->id)->where('userType','supporter')->where('user_id',$user_id)->get();
            if(count($exist) < 1 ) {
                if (date('Y-m-d-H:i:s',strtotime($record->created_at)) < date('Y-m-d H:i:s', strtotime('-3 days')) ){
                    $orders_no_answer_delivery_new [] = $record->id;
                }
            }

        }
        return $orders_no_answer_delivery_new;
    }


}
