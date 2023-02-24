<?php

namespace App\Http\Controllers\Admin;

use App\Admin\District;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Seller;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ZonesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guard('admin')->user()->is_super_admin) {
            $records = Zone::orderBy('id', 'ASC')->get();
        }else{
            $country = Auth::guard('admin')->user()->country;
            if ($country) {
                $cities = $country->cities;
            } else {
                $cities = [];
            }

           $records = [];
           foreach($cities as $city){
               $city_zones = $city->zones;
               foreach($city_zones as $zone){
                   $records[] = $zone;
               }
           }

        }
        return view('admin.zones.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $records = City::get();
        $countries  = Country::get();
        if(Auth::guard('admin')->user()->is_super_admin){
            $cities = City::get();
        }else{
            $cities = City::where('country_id',Auth::guard('admin')->user()->country_id)->get();
        }
        return view('admin.zones.create',compact('records','countries','cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|unique:zones',
            'title_ar' => 'required|unique:zones',
        ]);
        Zone::create([
            'title_en'=>$request->title_en,
            'title_ar'=>$request->title_ar,
            'city_id'=>$request->city_id,
            'from'=>"",
            'to'=>"",
            'description'=>"[]",
        ]);
        return redirect()->back()->with('success','Zone Added Successfully');
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
    public function addAlternative(){
     $zone =  Zone::find(1);
     $users = Seller::get();
     $res = [];
     foreach($users as $user){
         $res  [] = $user->id;
     }
    $zone->update([
       'description'=>json_encode($res)
    ]);
    }
    public function viewAlternative($id){
        $zone =  Zone::find($id);
        $old_users = json_decode($zone->description);
        $res  = Delivery::whereIn('id',$old_users)->get();
        if(count($res)> 0){
            return $res;
        }else{
            return [];
        }
        //Delivery::whereNotIn()
    }
    public function actionAlternative($zone_id,$delivery,$action){
        $zone =  Zone::find($zone_id);
        $description = json_decode($zone->description);
        if($action == 'add'){
            $description [] = $delivery;
        }else{
            for($i=0;$i< count($description); $i++) {
                if($description[$i] == $delivery){
                    unset($description[$i]);
                    $zone->update(['description'=>$description]);
                }else{
                    return 2;
                }
            }
        }
        return redirect()->back()->with('success','Done Successfully');
    }
    public function actionAlternativePost(Request $request){
        $zone_id = $request->zone_id;
        $delivery = $request->delivery;
        $action = $request->action ;

        $zone =  Zone::find($zone_id);
        $description = json_decode($zone->description);
        if($action == 'add') {
            $description [] = $delivery;
        }
        $zone->update(['description'=>$description]);
        return redirect()->back()->with('success','Done Successfully');
    }
    function getOtherDeliveries($id){
        $zone =  Zone::find($id);
        $old_users = json_decode($zone->description);
        $zone_users  = Delivery::where('zone_id',$id)->get();
        foreach($zone_users as $user){
            $old_users [] = $user->id;
        }
        $res= Delivery::whereNotIn('id',$old_users)->get();
        if(count($res)> 0){
            return $res;
        }else{
            return [];
        }
        //Delivery::whereNotIn()
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @res \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Zone::find($id);
        $countries = Country::get();
        if(Auth::guard('admin')->user()->is_super_admin){
            $cities = City::get();
        }else{
            $cities = City::where('country_id',Auth::guard('admin')->user()->country_id)->get();
        }
        return view('admin.zones.edit',compact('record','countries','cities'));
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
        $record = Zone::find($id);
        $record->update([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'city_id' => $request->city_id,
            'from' => '',
            'to' => '',
            'description' => '[]',
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
        $cities = District::where('zone_id',$id)->count();
        $orders = Order::where('zone_id',$id)->count();

        if($cities > 0 || $orders  > 0 ) {
            return redirect()->back()->with('error', 'Zone in use');
        }

        Zone::destroy($id);
        return redirect()->back()->with('success','Zone Delete Successfully');
    }
}
