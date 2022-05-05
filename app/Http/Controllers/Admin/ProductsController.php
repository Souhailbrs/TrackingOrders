<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\ProductSeller;
use App\Models\SalesChannels;
use App\Models\Seller;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProducts(){
        $back =0;
       $records =  ProductSeller::orderBy('id','DESC')->get();
       return view('admin.inventory.products.index', compact('records','back'));
    }
    public function getProductsSeller($id){
        $back =1;
        $records =  ProductSeller::where('seller_id',$id)->get();
        return view('admin.inventory.products.index', compact('records','back'));
    }
    public function getShipments(){
        $back =1;
        $records =  Inventory::orderBy('id','DESC')->get();
        return view('admin.inventory.shipments.index', compact('records','back'));
    }
    public function getShipmentsSeller($id){
        $seller_id = $id;
        $seller = Seller::find($id);
        $salesChannels =SalesChannels::where('owner_email',$seller->email)->get();
        $ids = [];
        foreach($salesChannels as $sale){
            $ids [ ] = $sale->id;
        }
        $back =1;
        $records =  Inventory::whereIn('sales_channel_id',$ids)->get();
        return view('admin.inventory.shipments.index', compact('records','back'));
    }
    function getSeller($sales_channel_type_id){
        $saleChannel =  SalesChannels::find($sales_channel_type_id);
        $email =$saleChannel->owner_email;
        $seller = Seller::where('email',$email)->first();
        return $seller;
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
