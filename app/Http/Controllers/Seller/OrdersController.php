<?php

namespace App\Http\Controllers\Seller;

use App\Exports\OrderssExport;
use App\Exports\Pagination;
use App\Http\Controllers\Controller;
use App\Imports\OrdersImport;
use App\Models\City;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderTrack;
use App\Models\ProductSeller;
use App\Models\SalesChannels;
use App\Models\Zone;
use App\WorkDay;
use App\WorkDayOrder;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class OrdersController extends Controller
{
    function __construct()
    {
        $this->page = 'orders';
        $this->pages = 'orders';
        //Old->0  New->0   New Order
        //old->0  New->1   Received by call center
        //CallCenter.
        //old->1  New->2  No Answer
        //old->1  New->3  Wrong Number    old->3  New->5 Not Confirmed
        //old->1  New->4  Confirmed
        //old->1  New->5  Not Confirmed
        //old->1  New->6  Ready to be wrapped
        //Packaginig
        //new->7 wrapped
        //Delivery Boy.
        //new->8  Added to box
        //Delivery
        //new->9 Customer Received
        //New->10  Customer did not Receive
        //new->11 Customer Did not reply
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $state, $from, $to)
    {
        $user_email = Auth::guard('seller')->user()->email;
        $shopTypes = SalesChannels::where('owner_email', $user_email)->get();
        $records = [];
        $shops = [];
        foreach ($shopTypes as $shop) {
            $shops[] = $shop->id;
        }
        if ($request->entries) {
            $pagination = $request->entries;
        } else {
            $pagination = 20;
        }
        if ($request->search) {
            $search = $request->search;
            $workDayOrders = Order::where('id', 'like', '%' . $search . '%')->orWhere('customer_phone1', 'like', '%' . $search . '%')->whereIn('sales_channel', $shops)->get();
        } else {
            $search = '';
            $workDayOrders = Order::get();
        }
        if ($state === 'today') {
            $workDayOrdersFilter = [];
            foreach ($workDayOrders as $order) {
                $order_date = date('Y-m-d', strtotime($order->created_at));
                $today = date('Y-m-d', strtotime(date('Y-m-d')));
                if ($order_date == $today) {
                    $workDayOrdersFilter[] = $order->id;
                }
            }
        } elseif ($state == '7days') {
            $workDayOrdersFilter = [];
            foreach ($workDayOrders as $order) {
                $order_date = date('Y-m-d', strtotime($order->created_at));
                $today = date('Y-m-d', strtotime(date('Y-m-d') . '-7 days'));
                if ($order_date >= $today) {
                    $workDayOrdersFilter[] = $order->id;
                }
            }
        } elseif ($state == 'custom') {
            $workDayOrdersFilter = [];
            foreach ($workDayOrders as $order) {
                $order_date = date('Y-m-d', strtotime($order->created_at));
                $from = date('Y-m-d', strtotime($from));
                $to = date('Y-m-d', strtotime($to));
                if ($order_date >= $from && $order_date <= $to) {
                    $workDayOrdersFilter[] = $order->id;
                }
            }
        }

        $records = Order::whereIn('id', $workDayOrdersFilter)->whereIn('sales_channel', $shops)->paginate($pagination);

        return view('seller.orders.index', compact('records', 'state', 'from', 'to', 'pagination', 'search', 'shopTypes'));
    }

    /*    public function index()
        {
            $user_email =  Auth::guard('seller')->user()->email;
            $shopTypes =   SalesChannels::where('owner_email',$user_email)->get();
            $records = [];
            foreach($shopTypes as $shop) {
                $orders = Order::where('sales_channel',$shop->id)->where('deleted',0)->get();
                foreach($orders as $ord){
                    $records [] = $ord;
                }
            }
            $filter = 0;
            $records = array_reverse($records, false);
            return view('seller.orders.index',compact('records','shopTypes','filter'));
        }*/
    public function filterOrdersWithShop($state)
    {
        $user_email = Auth::guard('seller')->user()->email;

        if ($state == 'all') {
            $shopTypes = SalesChannels::where('owner_email', $user_email)->get();
            $records = [];
            foreach ($shopTypes as $shop) {
                $orders = Order::where('sales_channel', $shop->id)->where('deleted', 0)->get();
                foreach ($orders as $ord) {
                    $records[] = $ord;
                }
            }
            $filter = 0;
        } else {
            $shopTypes = SalesChannels::where('id', $state)->get();

            $records = [];
            foreach ($shopTypes as $shop) {
                $orders = Order::where('sales_channel', $shop->id)->where('deleted', 0)->get();
                foreach ($orders as $ord) {
                    $records[] = $ord;
                }
            }
            $filter = 1;
        }
        return view('seller.orders.index', compact('records', 'shopTypes', 'filter'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'image' => 'required',
        ]);
        $path = $request->file('image');
        $response = Excel::import(new OrdersImport($request->sales_channel_id), $path);
        if ($response) {
            return redirect()->back()->with('success', 'updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Some thing went wrong .');
        }
    }

    public function hide($id, $state)
    {
        $order = Order::find($id);
        $order->update([
            'deleted' => intval($state)
        ]);
        return 1;
        //return redirect()->back()->with('success','Done Successfully');
    }

    public function postDate(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        return redirect()->route('seller.orders.index', ['state' => 'custom', 'from' => $from, 'to' => $to]);
    }

    public function hideProduct($id, $state)
    {
        $order = ProductSeller::find($id);
        $shipments = Inventory::where('product_name', $id)->count();
        if ($shipments > 0) {
            return 0;
        }
        $order->delete();
        return 1;
        //return redirect()->back()->with('success','Done Successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_email = Auth::guard('seller')->user()->email;

        $action = 'store';
        $page = $this->page;
        $pages = $this->pages;

        $shopTypes = SalesChannels::where('owner_email', $user_email)->get();


        $countries = Country::get();
        $zones = Zone::get();
        $shops = SalesChannels::where('owner_email', $user_email)->get();

        return view('seller.' . $page . '.control', compact('action', 'page', 'pages', 'shopTypes', 'countries', 'zones', 'shops'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Shop ID
        $sales_channel_id = $request->sales_channel_id;
        $shop = SalesChannels::find($request->sales_channel_id);
        $customer_name = $request->customer_name;
        $customer_phone1 = $request->phone_number['full'];
        $customer_phone2 = $request->phone_number['full'];
        $customer_notes = $request->customer_notes;
        $country_id = $shop->country->id;
        $city_id = $request->city_id;
        $zone_id = $request->zone_id;
        $customer_address = $request->customer_address;
        $delivery_date = $request->delivery_date;
        //Sale Channel Order
        if ($request->products_id) {
            //Order Products
            $products_number = count($request->products_id) - 1;
            if ($products_number == 0) {
                return redirect()->back()->with('error', 'Your order must have at least one product');
            }
            $order = Order::create([
                'sales_channel' => $sales_channel_id,
                'customer_name' => $customer_name,
                'customer_phone1' => $customer_phone1,
                'customer_phone2' => $customer_phone2,
                'customer_notes' => $customer_notes,
                'country_id' => $country_id,
                'city_id' => $city_id,
                'zone_id' => $zone_id,
                'address' => $customer_address,
                'status' => 0,
                'delivery_date' => $delivery_date,
                'url' => $request->url
            ]);
            for ($i = 0; $i < $products_number; $i++) {
                OrderProduct::create([
                    'sales_channele_order' => $order->id,
                    'product_id' => $request->products_id[$i],
                    'amount' => $request->products_amount[$i],
                    'price' => $request->products_price[$i]

                ]);
            }
            //Order Track
            OrderTrack::create([
                'sales_channele_order' => $order->id,
                'old_status' => 0,
                'last_status' => 0,
                'changes' => ''
            ]);
            $user_id = Auth::guard('seller')->user()->id;
            $this->ordeLog($user_id, $order->id, 0);
            return redirect()->back()->with('success', $this->page . 'Added Successfully');
        } else {
            return redirect()->back()->with('error', $this->page . 'Your Order Must Have One Product At least');
        }
        //dd($data);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
