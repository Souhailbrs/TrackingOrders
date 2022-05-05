<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\ProductSeller;
use App\Models\SalesChannels;
use App\Models\SalesChannelsType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{

    function __construct()
    {
        $this->page = 'inventory';
        $this->pages = 'inventories';
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

        $email = Auth::guard('seller')->user()->email;
        $shops = SalesChannels::where('owner_email',$email)->get();
        $inv_products = [];
        foreach($shops as $shop){
            foreach($shop->products as $product){
                if($product->status == 1) {
                    $inv_products [] = $product;
                }
            }
        }
        $records = $inv_products;

        return view('seller.'. $page .'.index',compact('page','pages','records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function MyProducts($action){
        switch($action){
            case 'view':
                $records = [];
                return view('seller.inventory.products.index',compact('records'));
            case 'break':

        }
    }
    public function create()
    {
        $user_email =  Auth::guard('seller')->user()->email;
        $user_id=  Auth::guard('seller')->user()->id;

        $action = 'store';
        $page =  $this->page;
        $pages =  $this->pages;
        $shopTypes =   SalesChannels::where('owner_email',$user_email)->get();
        $cities = City::get();
        $countries = Country::get();
        $shops = SalesChannels::where('owner_email',$user_email)->get();

        $all_selelr_products = ProductSeller::where('seller_id',$user_id)->where('status',1)->get();
        return view('seller.'. $page .'.control',compact('action','page','pages','shopTypes','cities','countries','shops','all_selelr_products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function myRquests(){
        $email = Auth::guard('seller')->user()->email;
        $shops = SalesChannels::where('owner_email',$email)->get();
        $inv_products = [];
        foreach($shops as $shop){
            foreach($shop->products as $product){
                if($product->status != 1) {
                    $inv_products [] = $product;
                }
            }
        }
        $records = $inv_products;
        return view('seller.inventory.requests',compact('records'));
    }
    public function store(Request $request)
    {

        Inventory::create([
            'sales_channel_id'=>$request->sales_channel_id,
            'shop_category'=>$request->shop_category,
            'product_name'=>$request->product_name,
            'company_name'=>$request->company_name,
            'company_number'=>$request->company_number,
            'delivery_type'=>$request->delivery_type,
            'boxes_number'=>$request->boxes_number,
            'product_amount'=>$request->product_amount,
            'Expected_time'=>$request->expected_time,
            'country_sent'=>$request->country_sent,
            'Actual_time'=>'',
            'sold'=>0,
            'status'=>0
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
        $user_email =  Auth::guard('seller')->user()->email;
        $action = 'update';
        $page =  $this->page;
        $pages =  $this->pages;
        $data = SalesChannels::find($id);
        $shopTypes =  SalesChannels::where('owner_email',$user_email)->get();
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
            'title_en'=>$request->title_en,
            'title_ar'=>$request->title_ar,
            'sales_channel_type_id'=>$request->sales_channel_type_id,
            'shop_url'=>$request->shop_url,
            'owner_email'=>$request->owner_email,
            'owner_password'=>$request->owner_password,
            'owner_phone'=>$request->owner_phone,
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
        SalesChannels::destroy($id);
        return redirect()->back()->with('success', $this->page . 'Deleted Successfully');
    }
}
