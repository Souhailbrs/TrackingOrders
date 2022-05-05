<?php

namespace App\Http\Controllers\Packaging;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\City;
use App\Models\Zone;
use App\WorkDay;
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
        $user_id =  Auth::guard('packaging')->user()->id;
        //Today State
        $today_work_days = WorkDay::where('user_id',$user_id)->where('completed',0)->get();
        if(count($today_work_days )> 0){
            $today_work =1;
            $work_day_id = $today_work_days[0]->id;
        }else {
            $today_work =0;
            $work_day_id =0;
        }

        $records = Box::where('creator_id',$user_id)->get();
        return view('packaging.boxes.index',compact('records','today_work'));
    }
    public function selectDelivery(Request $request){
       $box=  Box::find($request->box_id);
        $box->update([
           'delivery_id'=>$request->delivery_id
        ]);
        return redirect()->back()->with('success','Done Successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id =  Auth::guard('packaging')->user()->id;
        //Today State
        $today_work_days = WorkDay::where('user_id',$user_id)->where('completed',0)->get();
        if(count($today_work_days )> 0){
            $today_work =1;
            $work_day_id = $today_work_days[0]->id;
        }else {
            $today_work =0;
            $work_day_id =0;
        }

        $cities = City::get();
        return view('packaging.boxes.create',compact('cities','today_work'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id =  Auth::guard('packaging')->user()->id;
        Box::create([
           'zone_id'=>$request->zone_id,
            'district_id'=>$request->district_id,
            'creator_id'=>$user_id,
            'status'=>0,
        ]);
        return redirect()->back()->with('success','added successfully');
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
