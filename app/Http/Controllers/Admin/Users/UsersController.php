<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Country;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Packaging;
use App\Models\SalesChannels;
use App\Models\Seller;
use App\Models\Supporter;
use App\Models\Zone;
use App\WorkDay;
use App\WorkDayOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::guard('admin')->user();
        if($user->is_super_admin) {
            $sellers = Seller::get();
            $admins = Admin::get();
            $supporters = Supporter::get();
            $deliveries = Delivery::get();
        }else{
            $sellers = Seller::where('country_id',$user->country_id)->get();
            $admins = Admin::where('country_id',$user->country_id)->get();
            $supporters = Supporter::where('country_id',$user->country_id)->get();
            $deliveries = Delivery::where('country_id',$user->country_id)->get();
        }
        return view('admin.users.index', compact('sellers', 'admins', 'supporters', 'deliveries'));
    }
    public function getStatistics(){

        return view('admin.users.statistics');
    }
    public function getUsers($type)
    {
        $user = Auth::guard('admin')->user();
        if($user->is_super_admin) {
            switch ($type) {
                case 'sellers':
                    $records = Seller::get();
                    break;
                case 'admins':
                    $records = Admin::get();
                    break;
                case 'supporters':
                    $records = Supporter::get();
                    break;
                case 'deliveries':
                    $records = Delivery::get();
                    break;
                case 'packagings':
                    $records = Packaging::get();
                    break;
            }
        }else{
            switch ($type) {
                case 'sellers':
                    $records = Seller::get();
                    break;
                case 'admins':
                    $records =Admin::where('country_id',$user->country_id)->get();
                    break;
                case 'supporters':
                    $records = Supporter::where('country_id',$user->country_id)->get();
                    break;
                case 'deliveries':
                    //Zones in a specific country
                    $user_country = $user->country;
                    $user_country_cities = $user_country->cities;
                    $zone_ids = [];
                    foreach ($user_country_cities as $city){
                        $city_zones = $city->zones;
                        foreach ($city_zones as $city_zone) {
                            $zone_ids [] = $city_zone->id;
                        }
                    }
                    if(count($zone_ids) > 0){
                        $records = Delivery::whereIn('zone_id',$zone_ids)->get();
                    }else{
                        $records = Delivery::get();

                    }
                    break;
                case 'packagings':
                    $records = Packaging::where('country_id',$user->country_id)->get();
                    break;
            }
        }

        return view('admin.users.index', compact('records','type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::get();
        return view('admin.users.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->image) {
            $fileName = $request->image->getClientOriginalName();
            $file_to_store = time() . '_' . $fileName;
            $request->image->move(public_path('assets/admin/users'), $file_to_store);
        }else {
            $file_to_store = 'default';
        }
        $userType = $request->userType;
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $phone = $request->phone;
        $user = Auth::guard('admin')->user();
        if($user->is_super_admin){
            $this->validate($request, [
                'country_id'=>'required'
            ]);
            $country_id = $request->country_id;
            if($country_id == 0){
                return redirect()->back()->with('error','Invalid Country!');
            }
        }else{
            $country_id = $user->country_id;
        }

        switch($userType){
            case 'seller':
                $this->validate($request, [
                    'email' => 'required|unique:sellers|unique:admins|unique:deliveries|unique:supporters|unique:packagings',
                    'phone' => 'required|unique:sellers|unique:admins|unique:deliveries|unique:supporters|unique:packagings',
                ]);
                Seller::create([
                    'name'=>$name,
                    'email'=>$email,
                    'password'=>Hash::make($request->password),
                    'phone'=>$phone,
                    'image'=>$file_to_store
                ]);
                break;
            case 'admin':
                $this->validate($request, [
                    'email' => 'required|unique:sellers|unique:admins|unique:deliveries|unique:supporters|unique:packagings',
                    'phone' => 'required|unique:sellers|unique:admins|unique:deliveries|unique:supporters|unique:packagings',
                ]);
                Admin::create([
                    'name'=>$name,
                    'email'=>$email,
                    'password'=>Hash::make($request->password),
                    'phone'=>$phone,
                    'image'=>$file_to_store,
                    'country_id'=>$country_id,
                    'is_super_admin'=>0
                ]);
                break;
            case 'delivery':
                $this->validate($request, [
                    'email' => 'required|unique:sellers|unique:admins|unique:deliveries|unique:supporters|unique:packagings',
                    'phone' => 'required|unique:sellers|unique:admins|unique:deliveries|unique:supporters|unique:packagings',
                    'zone_id'=>'required'
                ]);
                $zone_id = $request->zone_id;
                if($zone_id == 0){
                    return redirect()->back()->with('error','Invalid Zone!');
                }
                Delivery::create([
                    'name'=>$name,
                    'email'=>$email,
                    'password'=>Hash::make($request->password),
                    'phone'=>$phone,
                    'image'=>$file_to_store,
                    'zone_id'=>$zone_id
                ]);
                break;
            case 'supporter':
                $this->validate($request, [
                    'email' => 'required|unique:sellers|unique:admins|unique:deliveries|unique:supporters|unique:packagings',
                    'phone' => 'required|unique:sellers|unique:admins|unique:deliveries|unique:supporters|unique:packagings',
                ]);
                Supporter::create([
                    'name'=>$name,
                    'email'=>$email,
                    'password'=>Hash::make($request->password),
                    'phone'=>$phone,
                    'image'=>$file_to_store,
                    'country_id'=>$country_id
                ]);
                break;
            case 'packaging':
                $this->validate($request, [
                    'email' => 'required|unique:sellers|unique:admins|unique:deliveries|unique:supporters|unique:packagings',
                    'phone' => 'required|unique:sellers|unique:admins|unique:deliveries|unique:supporters|unique:packagings',
                ]);
                Packaging::create([
                    'name'=>$name,
                    'email'=>$email,
                    'password'=>Hash::make($request->password),
                    'phone'=>$phone,
                    'image'=>$file_to_store,
                    'country_id'=>$country_id
                ]);
                break;
        }
        return redirect()->back()->with('success','User Added Successfully !');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$type)
    {
        $countries = Country::get();
        $types = $type;
        $type =substr_replace($type, '', -1);
        $zones = Zone::get();
         if($type == 'deliverie'){
             $type ='delivery';
         }
        switch($type){
            case  'admin':
                $user = Admin::find($id);
             break;
            case 'seller':
                $user = Seller::find($id);
                break;
            case 'supporter':
                $user = Supporter::find($id);
                break;
            case 'packaging':
                $user = Packaging::find($id);
                break;
            case 'delivery':
                $user = Delivery::find($id);
                break;
        }
        return view('admin.users.edit',compact('id','type','types','user','zones','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         if($request->status){
             $status  =  1;
         }else{
             $status  =  0;
         }

        $type = $request->type;
        switch($type){
            case  'admin':
                $user = Admin::find($id);
                break;
            case 'seller':
                $user = Seller::find($id);
                break;
            case 'supporter':
                $user = Supporter::find($id);
                break;
            case 'packaging':
                $user = Packaging::find($id);
                break;
            case 'delivery':
                $user = Delivery::find($id);
                $user->update([
                    'zone_id' =>$request->zone_id
                ]);
                break;
        }

     if($request->new_pas) {
         $user->update([
             'password' => Hash::make($request->new_pas)
         ]);
     }
     if($request->country_id){
         $user->update([
             'country_id' => $request->country_id
         ]);
     }
        if($request->image){
            $fileName = $request->image->getClientOriginalName();
            $file_to_store = time() . '_' . $fileName;
            $request->image->move(public_path('assets/admin/users'), $file_to_store);

            $user->update([
                'image' => $file_to_store
            ]);
        }


        $user->update([
           'email'=>$request->email,
           'phone'=>$request->phone,
           'name'=>$request->name,
            'status'=>$status
        ]);
        return redirect()->back()->with('success','User Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$type)
    {

        switch($type){
            case  'admins':
                $user = Admin::find($id);
                break;
            case 'sellers':
                $user = Seller::find($id);
                $SalesChannels =  SalesChannels::where('owner_email',$user->email)->count();
                if($SalesChannels > 0){
                    return redirect()->back()->with('error','User in use !');
                }
                break;
            case 'supporters':
                $WorkDay =  WorkDay::where('user_type','supporter')->where('user_id',$id)->count();
                $WorkDayOrder =  WorkDayOrder::get('userType','supporter')->where('userID',$id)->count();
                $user = Supporter::find($id);
                if($WorkDay > 0 || $WorkDayOrder > 0){
                    return redirect()->back()->with('error','User in use !');
                }
                break;
            case 'packagings':
                $WorkDay =  WorkDay::where('user_type','packaging')->where('user_id',$id)->count();
                $WorkDayOrder =  WorkDayOrder::get('userType','packaging')->where('userID',$id)->count();
                $user = Packaging::find($id);
                if($WorkDay > 0 || $WorkDayOrder > 0){
                    return redirect()->back()->with('error','User in use !');
                }
                break;
            case 'deliveries':
                $WorkDay =  WorkDay::where('user_type','delivery')->where('user_id',$id)->count();
                $WorkDayOrder =  WorkDayOrder::get('userType','delivery')->where('userID',$id)->count();
                if($WorkDay > 0 || $WorkDayOrder > 0){
                    return redirect()->back()->with('error','User in use !');

                }
                $user = Delivery::find($id);
                break;
        }
        return $user;
        $user->delete();
        return redirect()->back()->with('success','User Deleted Successfully !');

    }
}
