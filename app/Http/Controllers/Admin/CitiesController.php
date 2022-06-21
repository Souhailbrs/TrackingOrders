<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guard('admin')->user()->is_super_admin){
            $records = City::get();

        }else{
            $records = City::where('country_id',Auth::guard('admin')->user()->country_id)->get();
        }

        return view('admin.cities.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $records = Country::get();
        return view('admin.cities.create',compact('records'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        City::create([
            'title_en'=>$request->title_en,
            'title_ar'=>$request->title_ar,
            'country_id'=>$request->country_id
        ]);
        return redirect()->back()->with('success','City Added Successfully');

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
        $record = City::find($id);
        $countries = Country::get();
        return view('admin.cities.edit',compact('id','record','countries'));
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
        $record = City::find($id);
        $record->update([
            'title_en'=>$request->title_en,
            'title_ar'=>$request->title_ar,
            'country_id'=>$request->country_id
        ]);
        return redirect()->back()->with('success', 'Done Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cities = Zone::where('city_id',$id)->count();
        $orders = Order::where('city_id',$id)->count();
        if($cities > 0 || $orders > 0) {
            return redirect()->back()->with('error', 'City in use');
        }

        City::destroy($id);
        return redirect()->back()->with('success','City Delete Successfully');
    }
}
