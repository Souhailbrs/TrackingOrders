<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\BoxOrder;
use App\Models\Order;
use App\WorkDay;
use App\WorkDayOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoxesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id =  Auth::guard('delivery')->user()->id;
        //Today State
        $today_work_days = WorkDay::where('user_id',$user_id)->where('completed',0)->get();
        if(count($today_work_days )> 0){
            $today_work =1;
            $work_day_id = $today_work_days[0]->id;
        }else {
            $today_work =0;
            $work_day_id =0;
        }
        $records = Box::where('delivery_id',$user_id)->where('status',1)->get();

        return view('delivery.boxes.index',['records'=>$records,'today_work'=>$today_work]);

    }
    public function orders($box_id){
        $user_id =  Auth::guard('delivery')->user()->id;
        //Today State
        $today_work_days = WorkDay::where('user_id',$user_id)->where('completed',0)->get();
        if(count($today_work_days )> 0){
            $today_work =1;
            $work_day_id = $today_work_days[0]->id;
        }else {
            $today_work =0;
            $work_day_id =0;
        }
        $records = [];
        $box = Box::find($box_id);
        $orders= $box->orders;
        foreach($orders as $rec){
            $records [] = Order::find($rec->sales_channele_order);
        }

        //state
        //1. today
        //2. all
        return view('delivery.boxes.orders',compact('records','today_work'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
