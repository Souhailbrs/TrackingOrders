<?php

namespace App\Http\Controllers\Admin;

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
    public function showRequests(){
        if(Auth::guard('admin')->user()->is_super_admin) {
            $records =  Inventory::where('status',0)->orderBy('id','DESC')->get();
        }else{
            $records = [];
            $inventories =  Inventory::where('status',0)->orderBy('id','DESC')->get();
            foreach($inventories as $inv){
                if($inv->shop->country_id == Auth::guard('admin')->user()->country_id){
                    $records [] = $inv;
                }
            }

        }
        return view('admin.inventory.requests',compact('records'));
    }
    public function index()
    {
        $page =  $this->page;
        $pages =  $this->pages;
        $records = SalesChannels::get();
        return view('admin.'. $page .'.index',compact('page','pages','records'));
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
        $shops = SalesChannels::get();

        return view('admin.'. $page .'.control',compact('action','page','pages','shopTypes','cities','countries','shops'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        SalesChannels::create([
            'title_en'=>$request->title_en,
            'title_ar'=>$request->title_ar,
            'sales_channel_type_id'=>$request->sales_channel_type_id,
            'shop_url'=>$request->shop_url,
            'owner_email'=>$request->owner_email,
            'owner_password'=>$request->owner_password,
            'owner_phone'=>$request->owner_phone,
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
        $data = Inventory::find($id);
        $shopTypes =  SalesChannelsType::get();
        $cities = City::get();
        $countries = Country::get();

        return view('admin.inventory.edit',compact('action','page','pages','data','shopTypes','cities','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function AcceptInv($state,$id){
        $inv = Inventory::find($id);
        $inv->update([
            'status'=>$state,
        ]);
        if($state == 1){
            $inv->update([
                'Actual_time'=>date('y-m-d h:i:s A')
            ]);
        }
        $product_seller = ProductSeller::find(intval($inv->product_name));
        $received = intval($product_seller->received);
        $received += intval($inv->product_amount);

        $amount = intval($product_seller->amount);
        $amount += intval($inv->product_amount);

        $product_seller->update([
            'received'=>  $received,
            'amount'=>$amount
        ]);

        return redirect()->back()->with('success', $this->page . 'Updated Successfully');

    }

    public function update(Request $request, $id)
    {
        if($request->status){
            $status =1;
        }else{
            $status =0;
        }
        $data = Inventory::find($id);
        $data->update([
            'shop_category'=>$request->shop_category,
            'company_name'=>$request->company_name,
            'company_number'=>$request->company_number,
            'delivery_type'=>$request->delivery_type,
            'boxes_number'=>$request->boxes_number,
            'product_amount'=>$request->product_amount,
            'Expected_time'=>$request->expected_time,

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
