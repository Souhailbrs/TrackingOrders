<?php

namespace App\Http\Controllers\Supporter;

use App\Events\OrderState;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderContact;
use App\Models\OrderProduct;
use App\Models\SalesChannels;
use App\Models\Seller;
use App\Models\Zone;
use App\WorkDay;
use App\WorkDayOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($state,$from,$to)
    {
        $user_id =  Auth::guard('supporter')->user()->id;
        //Today State
        $today_work_days = WorkDay::where('user_id',$user_id)->where('user_type','supporter')->where('completed',0)->get();
        if(count($today_work_days )> 0){
            $today_work =1;
            $work_day_id = $today_work_days[0]->id;
        }else {
            $today_work =0;
            $work_day_id =0;
        }
        $records = [];
        if($state === 'today'){
            $workDayOrdersFilter=  WorkDayOrder::where('userType','supporter')->where('user_user_work_day',$work_day_id)->where('userID',$user_id)->get();
        }elseif($state == '7days') {
            $workDayOrders= WorkDayOrder::where('userType', 'supporter')->where('userID', $user_id)->get();
            $workDayOrdersFilter = [];
            foreach($workDayOrders as $order){
                $order_date = date('Y-m-d', strtotime($order->created_at));
                $today =  date('Y-m-d', strtotime( date('Y-m-d') . '-7 days'));
                if($order_date >= $today){
                    $workDayOrdersFilter []  =$order;
                }

            }
        }elseif($state == 'custom') {
            $workDayOrders= WorkDayOrder::where('userType', 'supporter')->where('userID', $user_id)->get();
            $workDayOrdersFilter = [];
            foreach($workDayOrders as $order){
                $order_date = date('Y-m-d', strtotime($order->created_at));
                $from = date('Y-m-d', strtotime($from));
                $to =  date('Y-m-d', strtotime($to));

                if( $order_date >=   $from && $order_date <= $to){
                    $workDayOrdersFilter []  =$order;
                }

            }

        }
            foreach( $workDayOrdersFilter as $work){
            $records []= Order::find($work->user_sales_channele_orders);
        }
        //state
        //1. today
        //2. all
        return view('supporter.orders.index',compact('records','today_work'));
    }
    public function viewWorkDayOrders($day){
        $user_id =  Auth::guard('supporter')->user()->id;
        //Today State
        $today_work_days = WorkDay::where('user_id',$user_id)->where('user_type','supporter')->where('completed',0)->get();
        if(count($today_work_days )> 0){
            $today_work =1;
            $work_day_id = $today_work_days[0]->id;
        }else {
            $today_work =0;
            $work_day_id =0;
        }
        $records = [];

        $work_day = WorkDay::find($day);
        $records_old =  $work_day->day_orders;

        foreach( $records_old as $rec){
            $records [] = $rec->order;
        }
        return view('supporter.orders.index',compact('records','today_work'));

    }
    public function postDate(Request $request){
        $from = $request->from;
        $to = $request->to;
        return redirect()->route('supporter.orders.index',['state'=>'custom','from'=>$from,'to'=>$to]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function end_order_word($order,$old,$new){
        $user_id =  Auth::guard('supporter')->user()->id;

        $my_order = Order::find($order);
        if($my_order->status != 1) {
            if($old == 4) {
                OrderState::broadcast($order, $old, $new);
                $my_order->update([
                    'status' => $new
                ]);
                $this->ordeLog($user_id,$order,$new);

            }

        }else{
            return redirect()->back()->with('error','You have to change order status');
        }
        $user_id =  Auth::guard('supporter')->user()->id;
        $work_days = WorkDay::where('user_type','supporter')->where('user_id',$user_id)->get();
        foreach($work_days as $wk_day){
            $id = $wk_day->id;
            $order_day = WorkDayOrder::where('user_user_work_day',$id)->where('userType','supporter')->where('userID',$user_id)->where('user_sales_channele_orders',$order)->get();
            foreach($order_day as $or_day){
                $or_day->update([
                    'status'=>1,
                    'order_status_to'=>date('y-m-d h:i:s')
                ]);
            }
        }
            return $this->getOrder();

     //   return redirect()->route('supporter.home');
    }

/*    public function getOrder(){
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
                return redirect()->route('supporter.home')->with('error','There is no orders yet!');
            }
        }else{
            return redirect()->back()->with('error','You Have To Start Your Day');
        }
    }*/
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


    public function IsCallCenterOrders($orders_ids,$supporter_id){
        $res = [];
        foreach($orders_ids as $order_id){
            $exist = OrderContact::where('sale_channele_order_id',$order_id)->where('userType','supporter')->where('user_id',$supporter_id)->first();
            if($exist){
                $res [] = $exist->order->id;
            }
        }
        return $res;
    }

    public  function getNextOrder(){
        // New Orders
        $New_Orders = $this->New_Orders();
        // Confirm Order at deliver day
        $Confirm_Order_at_deliver_day = $this->Confirm_Order_at_deliver_day();
        // No Answer Delivery.
        $No_Answer_Delivery = $this->No_Answer_Delivery_Orders();
        // Customer Cancelled Delivery
        //$Customer_Cancelled_callCenter= $this->Customer_Cancelled_callCenter();
        $Customer_Cancelled_callCenter =[];
        // Customer Cancelled Delivery
        $customer_cancelled_delivery = $this->Customer_Cancelled_Delivery();
        // No Answer Call Center
        $No_Answer_Call_Center = $this->No_Answer_Call_Center();
        // Not Confirmed
        $Not_Confirmed = $this->Not_Confirmed();
        $res = array_merge($No_Answer_Delivery,$Customer_Cancelled_callCenter,$customer_cancelled_delivery,$Confirm_Order_at_deliver_day,$New_Orders,$No_Answer_Call_Center,$Not_Confirmed);
        $res =array_unique($res);
        if(count($res) > 0){
            return Order::find($res[0]);
        }else{
            return 0;
        }
    }
    // No Answer Delivery Orders.
    public  function  No_Answer_Delivery_Orders(){
        $user_id =  Auth::guard('supporter')->user()->id;
        $orders_no_answer_delivery = Order::where('id','>=',1000)->where('status',12)->where('deleted',0)->get();
        $orders_no_answer_delivery_new = [];
        foreach($orders_no_answer_delivery as $record){
            $exist = OrderContact::where('status',12)->where('sale_channele_order_id',$record->id)->where('created_at', '>=', date('Y-m-d').' 00:00:00')->get();
            if (count($exist) < 2) {
                if (count($exist) < 1) {
                    $orders_no_answer_delivery_new [] = $record->id;
                } else {
                    if (date('Y-m-d-H:i:s', strtotime($exist[0]->updated_at)) < date('Y-m-d H:i:s', strtotime('-4 Hours'))) {
                        $orders_no_answer_delivery_new [] = $record->id;
                    }
                }
            }


        }
        $orders_no_answer_delivery_new = $this->IsCallCenterOrders($orders_no_answer_delivery_new,$user_id);
        return $orders_no_answer_delivery_new;
    }
    // Customer Cancelled Delivery.
    public function  Customer_Cancelled_callCenter(){
        $user_id =  Auth::guard('supporter')->user()->id;

        $orders_no_answer_delivery = Order::where('id','>=',1000)->where('status',6)->where('deleted',0)->get();
        $orders_no_answer_delivery_new = [];
        foreach($orders_no_answer_delivery as $record){
            $exist = OrderContact::where('status',6)->where('sale_channele_order_id',$record->id)->where('userType','supporter')->where('user_id',$user_id)->get();
            if(count($exist) <=  0){
                $orders_no_answer_delivery_new [] = $record->id;
            }
        }
        $orders_no_answer_delivery_new = $this->IsCallCenterOrders($orders_no_answer_delivery_new,$user_id);

        return $orders_no_answer_delivery_new;
    }
    // Customer Cancelled Delivery.
    public function  Customer_Cancelled_Delivery(){
        $user_id =  Auth::guard('supporter')->user()->id;

        $orders_no_answer_delivery = Order::where('id','>=',1000)->where('status',11)->where('deleted',0)->get();
        $orders_no_answer_delivery_new = [];
        foreach($orders_no_answer_delivery as $record){
            $exist = OrderContact::where('status',11)->where('sale_channele_order_id',$record->id)->get();
            if(count($exist) <=  0){
                $orders_no_answer_delivery_new [] = $record->id;
            }
        }
        $orders_no_answer_delivery_new = $this->IsCallCenterOrders($orders_no_answer_delivery_new,$user_id);

        return $orders_no_answer_delivery_new;
    }

    // Confirm Order at deliver day
    public function  Confirm_Order_at_deliver_day(){
        $user_id =  Auth::guard('supporter')->user()->id;
        //Delivery date
        //Confirmed date
        $orders_no_answer_delivery = Order::where('id','>=',1000)->where('status',7)->where('delivery_date','=', Carbon::today())->where('deleted',0)->get();
        $orders_no_answer_delivery_new = [];
        foreach($orders_no_answer_delivery as $record){
            $exist = OrderContact::where('status',4)->where('sale_channele_order_id',$record->id)->where('userType','supporter')->where('user_id',$user_id)->get();

            //If creation date is equal to delivery date or less than one
            //ignore
            //Otherwise
            //Call Him.
            foreach($exist as $ex){
                $contact_before = date('Y-m-d', strtotime($ex->created_at));
                $delivery_date = $record->delivery_date;
                $limit = date('Y-m-d', strtotime($contact_before. ' + 2 day'));
                //12
                //13
                //14
                //15
                $res = [
                    'limit'=>$limit,
                    'delivery_date'=>$delivery_date,
                    'contact_before'=>$contact_before
                ];
                // dd($res);
                if($limit  > $delivery_date){
                    //Ignore
                    continue;
                }elseif($limit <= $delivery_date){
                    //Contact 12
                    //Deliver 12 or 13 //ignore
                    //otherwise
                    //takeId
                    $orders_no_answer_delivery_new [] = $record->id;
                }else{
                    //Ignore Same Day
                    continue;
                }

                $orders_no_answer_delivery_new [] = $record->id;


            }


            $orders_no_answer_delivery_new = array_unique($orders_no_answer_delivery_new);
        }
        $orders_no_answer_delivery_new = $this->IsCallCenterOrders($orders_no_answer_delivery_new,$user_id);

        return $orders_no_answer_delivery_new;
    }

    // New Orders.
    public function New_Orders(){

        $orders_no_answer_delivery = Order::where('id','>=',1000)->where('status',0)->where('deleted',0)->get();
        $ids = [];
        foreach($orders_no_answer_delivery as $record){
            $ids [] = $record->id;
        }
        return $ids;
    }
    // No Answer Call Center
    public  function  No_Answer_Call_Center(){
        $user_id =  Auth::guard('supporter')->user()->id;
        $orders_no_answer_delivery = Order::where('id','>=',1000)->where('status',2)->where('deleted',0)->get();
        $orders_no_answer_delivery_new = [];
        foreach($orders_no_answer_delivery as $record){
            $exist = OrderContact::where('status',2)->where('sale_channele_order_id',$record->id)->where('created_at', '>=', date('Y-m-d').' 00:00:00')->where('userType','supporter')->where('user_id',$user_id)->get();
            if(count($exist) < 2 ){
                if(count($exist) < 1 ) {
                    $orders_no_answer_delivery_new [] = $record->id;
                }else{

                    if (date('Y-m-d h:i:sa',strtotime($exist[0]->updated_at)) < date('Y-m-d h:i:sa', strtotime('-1 Hours')) ){

                        $orders_no_answer_delivery_new [] = $record->id;
                    }

                }
            }
        }
        $orders_no_answer_delivery_new = $this->IsCallCenterOrders($orders_no_answer_delivery_new,$user_id);
        return $orders_no_answer_delivery_new;
    }
    // Not Confirmed
    public  function  Not_Confirmed(){
        $user_id =  Auth::guard('supporter')->user()->id;
        $orders_no_answer_delivery = Order::where('id','>=',1000)->where('status',5)->where('deleted',0)->get();
        $orders_no_answer_delivery_new = [];
        foreach($orders_no_answer_delivery as $record){
            $exist = OrderContact::where('status',5)->where('sale_channele_order_id',$record->id)->get();
            if(count($exist) < 1 ) {
                if (date('Y-m-d-H:i:s',strtotime($record->created_at)) < date('Y-m-d H:i:s', strtotime('-3 Days')) ){
                    $orders_no_answer_delivery_new [] = $record->id;
                }
            }

        }
        $orders_no_answer_delivery_new = $this->IsCallCenterOrders($orders_no_answer_delivery_new,$user_id);

        return $orders_no_answer_delivery_new;
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
    public function change_order_state($order,$old,$new){

        $user_id =  Auth::guard('supporter')->user()->id;
       OrderContact::create([
           'sale_channele_order_id'=>$order,
           'times'=>1,
           'status'=>$new,
           'user_id'=>$user_id,
           'userType'=>'supporter',
       ]);


        OrderState::broadcast($order,$old,$new);
        $order = Order::find($order);
        $order->update([
           'status'=>$new
        ]);
        $user_id_seller = Seller::where('email',$order->shop->owner_email)->first()->id;
        $this->ordeLog($user_id_seller,$order->id,$new);

        return redirect()->route('supporter.getOrder');

    }
    public function update(Request $request, $id)
    {
        $order = OrderProduct::find($id);
        if($request->products_id) {
            $products_number = count($request->products_id) - 1;
            $old_orders = OrderProduct::where('sales_channele_order', $id)->get();
            foreach ($old_orders as $old) {
                $old->delete();
            }
            for ($i = 0; $i < $products_number; $i++) {
                OrderProduct::create([
                    'sales_channele_order' => $id,
                    'product_id' => $request->products_id[$i],
                    'amount' => $request->products_amount[$i],
                    'price' => $request->products_price[$i],
                    'delivery_date' => $request->delivery_date
                ]);
            }
        }
        $real_order = Order::find($id);
        if($request->notes){
            $notes = $request->notes;
        }else{
            $notes = $real_order->notes;
        }
        if($request->country_id){
            $country_id = $request->country_id;
        }else{
            $country_id = $real_order->country_id;
        }
        if($request->city_id){
            $city_id = $request->city_id;
        }else{
            $city_id = $real_order->city_id;
        }

        if($request->zone_id){
            $zone_id = $request->zone_id;
        }else{
            $zone_id = $real_order->zone_id;
        }

        if($request->district_id){
            $district_id = $request->district_id;
        }else{
            $district_id = $real_order->district_id;
        }

        if($request->customer_address){
            $customer_address = $request->customer_address;
        }else{
            $customer_address = $real_order->customer_address;
        }

        if($request->delivery_date){
            $delivery_date = $request->delivery_date;
        }else{
            $delivery_date = $real_order->delivery_date;
        }
        if($request->cancelled_order){
            $notes = "الغي بسبب" . " ". $notes;

        }
        $real_order->update([
            'notes'=>$notes,
            'city_id'=>$city_id,
            'zone_id'=>$zone_id,
            'district_id'=>$district_id,
            'address'=>$customer_address,
            'delivery_date'=>$delivery_date

        ]);
        if($request->state){
            return $this->change_order_state($real_order->id, $real_order->status, $request->state);
        }else{
            return redirect()->route('supporter.getOrder');
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
