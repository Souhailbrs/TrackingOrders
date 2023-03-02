<?php

namespace App\Http\Controllers\Site;

use App\Admin\District;
use App\Events\OrderState;
use App\Exports\OrderssExport;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderContact;
use App\Models\OrderProduct;
use App\Models\ProductSeller;
use App\Models\SalesChannels;
use App\Models\Seller;
use App\Models\Zone;
use App\WorkDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class CustomOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::guard('supporter')->check()) {
            $user_id = Auth::guard('supporter')->user()->id;
            $today_work_days = WorkDay::where('user_id', $user_id)->where('user_type', 'supporter')->where('completed', 0)->get();
            if (count($today_work_days) > 0) {
                $today_work = 1;
                $work_day_id = $today_work_days[0]->id;
            } else {
                $today_work = 0;
                $work_day_id = 0;
            }
        } else {
            $today_work = 0;
            $work_day_id = 0;
        }

        $order = Order::find($id);
        return view('admin.orders.custom.show', compact('order', 'today_work'));
    }
    public function showOrder($id)
    {
        $order = Order::find($id);
        return view('packaging.orders.custom.show', compact('order'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::guard('supporter')->check()) {
            $user_id = Auth::guard('supporter')->user()->id;
            $today_work_days = WorkDay::where('user_id', $user_id)->where('user_type', 'supporter')->where('completed', 0)->get();
            if (count($today_work_days) > 0) {
                $today_work = 1;
                $work_day_id = $today_work_days[0]->id;
            } else {
                $today_work = 0;
                $work_day_id = 0;
            }
        } else {
            $today_work = 0;
            $work_day_id = 0;
        }

        $order = Order::find($id);
        $countries = Country::get();
        if ($order->country) {
            $cities = City::where('country_id', $order->country->id)->get();
        } else {
            $cities = [];
        }
        if ($order->city) {
            $zones = Zone::where('city_id', $order->city->id)->get();
        } else {
            $zones = [];
        }
        if ($order->zone) {
            $districts = District::where('zone_id', $order->zone->id)->get();
        } else {
            $districts = [];
        }
        if ($order->shop) {
            $seller = Seller::where('email', $order->shop->owner_email)->first();
            $product_seller = ProductSeller::where('seller_id', $seller->id)->get();
        } else {
            $product_seller = [];
        }
        return view('admin.orders.custom.edit', compact('order', 'countries', 'cities', 'zones', 'districts', 'product_seller', 'today_work'));
    }

    public function OrderProducsActions(Request $request, $order_id)
    {
        return 1;
        $product_id = $request->product_seller_new;
        $amount = $request->product_seller_amount;
        $price = $request->product_seller_price;
        OrderProduct::create([
            'sales_channele_order' => $order_id,
            'product_id' => $product_id,
            'amount' => $amount,
            'price' => $price,
        ]);
        return redirect()->back();
    }

    public function addProductOrder(Request $request)
    {
        $order_id = intval($request->order_id);
        $product_id = intval($request->product_id);
        $amount = intval($request->product_seller_amount);
        $price = intval($request->product_seller_price);

        $data = OrderProduct::create([
            'sales_channele_order' => $order_id,
            'product_id' => $product_id,
            'amount' => $amount,
            'price' => $price,
        ]);
        return response()->json($data);
    }

    public function removeProductOrder($id)
    {
        $order = OrderProduct::find($id);
        $order->delete();
        return redirect()->back();
    }

    public function change_order_state(Request $request)
    {
        $order = $request->order_id;
        $old = $request->old_status;
        $new = $request->new_status;
        if ($new != "99999999") {
            if (Auth::guard('admin')->check()) {
                $user_id = Auth::guard('admin')->user()->id;
                $userType = 'admin';
            }
            if (Auth::guard('seller')->check()) {
                $user_id = Auth::guard('seller')->user()->id;
                $userType = 'seller';
            }
            if (Auth::guard('supporter')->check()) {
                $user_id = Auth::guard('supporter')->user()->id;
                $userType = 'supporter';
            }
            if (Auth::guard('packaging')->check()) {
                $user_id = Auth::guard('packaging')->user()->id;
                $userType = 'packaging';
            }
            OrderContact::create([
                'sale_channele_order_id' => $order,
                'times' => 1,
                'status' => $new,
                'user_id' => $user_id,
                'userType' => $userType,
            ]);


            OrderState::broadcast($order, $old, $new);
            $order = Order::find($order);
            $order->update([
                'status' => $new
            ]);
            $user_id_seller = Seller::where('email', $order->shop->owner_email)->first()->id;
            $this->ordeLog($user_id_seller, $order->id, $new);
        }
        return 1;

    }

    public function change_order_product_details(Request $request)
    {
        $OrderProductId = intval($request->OrderProductId);
        $orderProduct = OrderProduct::find($OrderProductId);
        $orderProduct->update([
            'amount' => $request->product_amount,
            'price' => $request->product_price,
        ]);
        return $orderProduct;
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
        $order = Order::find($id);
        /*Country*/
        if ($request->country_id && $request->country_id != 0) {
            $country = $request->country_id;
        } else {
            $country = $order->country_id;
        }
        /*City*/
        if ($request->city_id && $request->city_id != 0) {
            $city = $request->city_id;
        } else {
            $city = $order->city_id;
        }
        /*Zone*/
        if ($request->zone_id && $request->zone_id != 0) {
            $zone = $request->zone_id;
        } else {
            $zone = $order->zone_id;
        }
        /*District*/
        if ($request->district_id && $request->district_id != 0) {
            $district = $request->district_id;
        } else {
            $district = $order->district_id;
        }
        $order->update([
            'customer_name' => $request->customer_name,
            'customer_phone1' => $request->customer_phone1,
            'customer_notes' => $request->customer_notes,
            'notes' => $request->notes,
            'country_id' => $country,
            'city_id' => $city,
            'zone_id' => $zone,
            'address' => $request->address,
            'district_id' => $district,
        ]);
        if ($order->sales_channel) {
            $sale_channel = SalesChannels::find($order->sales_channel);
            $sale_channel->update([
                'title_en' => $request->shop_title_ar,
                'title_ar' => $request->shop_title_ar,
                'shop_url' => $request->shop_url,
                'owner_email' => $request->owner_email,
                'owner_phone' => $request->owner_phone,
            ]);
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportOrders($pagination)
    {
        $export= new OrderssExport;
        $export::$pagination=$pagination;
        return Excel::download($export, 'orders.xlsx');
    }

    public function destroy($id)
    {
        $orders = \App\Models\Order::where('id', $id)->get();
        foreach ($orders as $ord) {
            $products = $ord->product;
            foreach ($products as $pro) {
                $pro->delete();
            }
            $contacts = \App\Models\OrderContact::where('sale_channele_order_id', $ord->id)->get();
            foreach ($contacts as $pro) {
                $pro->delete();
            }
            $log = \App\Models\OrderLog::where('order_id', $ord->id)->get();
            foreach ($log as $pro) {
                $pro->delete();
            }
            $tracks = \App\Models\OrderTrack::where('sales_channele_order', $ord->id)->get();
            foreach ($tracks as $pro) {
                $pro->delete();
            }
            $workday = \App\WorkDayOrder::where('user_sales_channele_orders', $ord->id)->get();
            foreach ($workday as $pro) {
                $pro->delete();
            }
            $ord->delete();
        }
        return redirect()->back()->with('success', 'Order Deleted Successfully');

    }

}
