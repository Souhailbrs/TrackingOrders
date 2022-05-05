<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductSeller;
use App\WorkDay;
use App\WorkDayOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($state,$from,$to)
    {
        if($state === 'today'){
            $workDayOrders = Order::get();
            $workDayOrdersFilter =[];
            foreach($workDayOrders as $order){
                $order_date = date('Y-m-d', strtotime($order->created_at));
                $today =  date('Y-m-d', strtotime( date('Y-m-d')));
                if($order_date == $today){
                    $workDayOrdersFilter []  =$order;
                }
            }
        }elseif($state == '7days') {
            $workDayOrders = Order::get();
            $workDayOrdersFilter =[];
            foreach($workDayOrders as $order){
                $order_date = date('Y-m-d', strtotime($order->created_at));
                $today =  date('Y-m-d', strtotime( date('Y-m-d') . '-7 days'));
                if($order_date >= $today){
                    $workDayOrdersFilter []  =$order;
                }

            }
        }elseif($state == 'custom') {
            $workDayOrders = Order::get();
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
        $records = $workDayOrdersFilter;

        return view('admin.orders.index',compact('records','state','from','to'));

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
        return redirect()->route('admin.orders.index',['state'=>'custom','from'=>$from,'to'=>$to]);
    }
    public function chnageProductStatus($id){
        $exist = ProductSeller::find($id);
        if($exist){
            if($exist->status ==1){
                $exist->update(['status'=>0]);
            }else{
                $exist->update(['status'=>1]);

            }
        }
        return redirect()->back()->with('success','Done Successfully');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.inventory.create');
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
    public function update(Request $request, $id)
    {
        //
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
