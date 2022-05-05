<?php

namespace App\Http\Controllers\Admin;

use App\Admin\District;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\Zone;
use Illuminate\Http\Request;
class DistrictsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = District::get();
        return view('admin.districts.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $records = Zone::get();
        $countries = Country::get();
        $cities = City::get();

        return view('admin.districts.create',compact('records','countries','cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        District::create([
            'title_en'=>$request->title_en,
            'title_ar'=>$request->title_ar,
            'zone_id'=>$request->zone_id,

        ]);
        return redirect()->back()->with('success','District Added Successfully');
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
        $record = District::find($id);
        $countries = Country::get();
        $cities = City::get();
        $zones = Zone::get();
        return view('admin.districts.edit',compact('record','countries','cities','zones'));
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
        $record = District::find($id);
        $record->update([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'zone_id' => $request->zone_id,
        ]);
        return redirect()->back()->with('success','Done Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orders = Order::where('district_id',$id)->count();
        if($orders > 0 ){
            return redirect()->back()->with('error', 'District in use');
        }
        District::destroy($id);
        return redirect()->back()->with('success','District Delete Successfully');
    }
}

