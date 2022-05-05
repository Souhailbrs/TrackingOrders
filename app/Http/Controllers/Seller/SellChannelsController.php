<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;

use App\Models\Inventory;
use App\Models\Order;
use App\Models\ProductSeller;
use App\Models\SalesChannels;
use App\Models\SalesChannelsType;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellChannelsController extends Controller
{
    public function __construct()
    {
        $this->page = 'sellChannel';
        $this->pages = 'sellChannels';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page =  $this->page;
        $pages =  $this->pages;
        $user_email =  Auth::guard('seller')->user()->email;

        $data = SalesChannels::where('owner_email',$user_email)->get();
        return view('seller.sellChannels.index',compact('page','pages','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page =  $this->page;
        $pages =  $this->pages;
        $shopTypes =  SalesChannelsType::get();
        $cities = City::get();
        $countries = Country::get();
        $sellers = Seller::get();
        return view('seller.sellChannels.control',compact('action','page','pages','shopTypes','cities','countries','sellers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $seller = Seller::find($request->owner_email);

        SalesChannels::create([
            'title_en'=>$request->title_ar,
            'title_ar'=>$request->title_ar,
            'sales_channel_type_id'=>$request->sales_channel_type_id,
            'shop_url'=>$request->shop_url,
            'owner_email'=>$seller->email,
            'owner_password'=>$seller->password,
            'owner_phone'=>$seller->phone,
            'country_id'=>$request->country_id,
            'city_id'=>$request->city_id,
            'status'=>1
        ]);
        return redirect()->back()->with('success', $this->page . 'Added Successfully');
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
        $action = 'update';
        $page =  $this->page;
        $pages =  $this->pages;
        $data = SalesChannels::find($id);
        $shopTypes =  SalesChannelsType::get();
        $cities = City::get();
        $countries = Country::get();
        return view('seller.sellChannels.control',compact('action','page','pages','data','shopTypes','cities','countries'));
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
        if($request->status){
            $status =1;
        }else{
            $status =0;
        }
        $data = SalesChannels::find($id);
        $data->update([
            'title_en'=>$request->title_ar,
            'title_ar'=>$request->title_ar,
            'sales_channel_type_id'=>$request->sales_channel_type_id,
            'shop_url'=>$request->shop_url,
            'country_id'=>$request->country_id,
            'city_id'=>$request->city_id,
            'status'=>$status
        ]);
        return redirect()->back()->with('success', $this->page . 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exist = Inventory::where('sales_channel_id',$id)->count();
        $exist_1 = ProductSeller::where('shop_id',$id)->count();
        $exist_2 = Order::where('sales_channel',$id)->count();

        if($exist > 0 && $exist_1 > 1 && $exist_2 > 1){
            return redirect()->back()->with('error','Can not delete this store because it has active products');

        }
        SalesChannels::destroy($id);

        return redirect()->back()->with('success', $this->page . 'Deleted Successfully');
    }
}
