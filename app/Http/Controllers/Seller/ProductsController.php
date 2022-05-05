<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\ProductSeller;
use App\Models\SalesChannels;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    function __construct()
    {
        $this->page = 'product';
        $this->pages = 'products';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::guard('seller')->user()->id;
        $records = ProductSeller::where('seller_id', $user_id)->get();
        return view('seller.inventory.products.index', compact('records'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_email = Auth::guard('seller')->user()->email;
        $shops = SalesChannels::where('owner_email',$user_email)->get();

        $action = 'store';
        $page = $this->page;
        $pages = $this->pages;


        return view('seller.inventory.products.control', compact('action', 'page', 'pages','shops'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::guard('seller')->user()->id;

        $fileName = $request->image->getClientOriginalName();
        $file_to_store = time() . '_' . $fileName ;
        $request->image->move(public_path('assets/admin/products'), $file_to_store);


        ProductSeller::create([
            'name' => $request->product_name,
            'received' => 0,
            'amount' => 0,
            'sold' => 0,
            'status' => 1,
            'seller_id' => $user_id,
            'image'=>$file_to_store,
            'shop_id'=>$request->sales_channel_id
        ]);
        return redirect()->back()->with('success', 'You have successfully added new product');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_email = Auth::guard('seller')->user()->email;
        $shops = SalesChannels::where('owner_email',$user_email)->get();

        $action = 'update';
        $page = $this->page;
        $pages = $this->pages;
        $data = ProductSeller::find($id);

        return view('seller.inventory.products.control', compact('action', 'page', 'pages','data','shops'));
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

        $data = ProductSeller::find($id);

        if($request->image){
            $fileName = $request->image->getClientOriginalName();
            $file_to_store = time() . '_' . $fileName ;
            $request->image->move(public_path('assets/admin/products'), $file_to_store);
        }else{
            $file_to_store = $data->data;
        }
        if($request->status){
            $status =1;
        }else{
            $status=0;
        }
        $data->update([
            'name'=>$request->product_name,
            'status'=>$status,
            'image'=>$file_to_store,
            'shop_id'=>$request->sales_channel_id
        ]);
        return redirect()->back()->with('success', 'You have successfully updated  your product');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function Delproduct($id){
        ProductSeller::destroy($id);
        return redirect()->back()->with('success', 'You have successfully updated  your product');
    }
    public function DelproductAjax(Request $request){
        ProductSeller::destroy($request->id);
        return 1;
    }
    public function destroy($id)
    {
        ProductSeller::destroy($id);
        return redirect()->back()->with('success', 'You have successfully updated  your product');

    }
}
