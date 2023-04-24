<?php

namespace App\Http\Controllers\Packaging;

use App\Events\OrderState;
use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\BoxOrder;
use App\Models\City;
use App\Models\Country;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductSeller;
use App\Models\SalesChannels;
use App\Models\Seller;
use App\Models\Zone;
use App\WorkDay;
use App\WorkDayOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class WrappingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_new(Request $request, $state, $from, $to)
    {
        $user_id =  Auth::guard('packaging')->user()->id;
        $today_work_days = WorkDay::where('user_id', $user_id)->where('user_type', 'packaging')->where('completed', 0)->get();
        $orders_user = WorkDayOrder::where('userID', $user_id)->where('userType', 'packaging')->pluck('user_sales_channele_orders')->all();
        if (count($today_work_days) > 0) {
            $today_work = 1;
            $work_day_id = $today_work_days[0]->id;
        } else {
            $today_work = 0;
            $work_day_id = 0;
        }
        if ($request->entries) {
            $pagination = $request->entries;
        } else {
            $pagination = 20;
        }
        if ($request->search) {
            $search = $request->search;
            $workDayOrders = Order::where('id', 'like', '%' . $search . '%')
                ->whereIn('id', $orders_user)
                ->orWhere('customer_phone1', 'like', '%' . $search . '%')
                ->whereIn('id', $orders_user)->get();
        } else {
            $search = '';
            $workDayOrders = Order::whereIn('id', $orders_user)->get();
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
        $user =  Auth::guard('packaging')->user();

        $records = Order::whereIn('id', $workDayOrdersFilter)->where('status', 7)->where('country_id', $user->country_id)->paginate($pagination);
        return view('packaging.wrap.index', compact('records', 'state', 'from', 'to', 'pagination', 'search', 'today_work'));
    }
    public function index(Request $request)
    {

        $user =  Auth::guard('packaging')->user();

        if ($request->entries) {
            $pagination = $request->entries;
        } else {
            $pagination = 20;
        }
        if ($request->search) {
            $search = $request->search;
            $workDayOrders = Order::where('id', 'like', '%' . $search . '%')->orWhere('customer_phone1', 'like', '%' . $search . '%')->get();
        } else {
            $search = '';
            $workDayOrders = Order::get();
        }
        $user_id =  Auth::guard('packaging')->user()->id;
        //Today State
        $today_work_days = WorkDay::where('user_id', $user_id)->where('completed', 0)->get();
        if (count($today_work_days) > 0) {
            $today_work = 1;
            $work_day_id = $today_work_days[0]->id;
        } else {
            $today_work = 0;
            $work_day_id = 0;
        }
        $records = Order::whereIn('status', [7, 4])->whereDate('delivery_date', date_format(Carbon::now(), "Y-m-d"))->where('country_id', $user->country_id)->get();
        //state
        //1. today
        //2. all
        return view('packaging.wrap.index', compact('records', 'today_work', 'search', 'pagination'));
    }
    public function sentOrders($day, $filter)
    {
        $user =  Auth::guard('packaging')->user();

        if ($filter == 'all') {
            $filtered = [8, 12, 6, 10];
        } else {
            $filtered = [$filter];
        }

        //day => today & all
        $user_id =  Auth::guard('packaging')->user()->id;
        //Today State
        // $today_work_days = WorkDay::where('user_id', $user_id)->where('completed', 0)->get();
        $today_work_days = WorkDay::where('user_id', $user_id)->where('user_type', 'packaging')->where('completed', 0)->get();
        $orders_user = WorkDayOrder::where('userID', $user_id)->where('userType', 'packaging')->pluck('user_sales_channele_orders')->all();
        if (count($today_work_days) > 0) {
            $today_work = 1;
            $work_day_id = $today_work_days[0]->id;
        } else {
            $today_work = 0;
            $work_day_id = 0;
        }
        if ($day == 'today') {
            $records = Order::WhereIn('status', $filtered)->whereDate('delivery_date', Carbon::today())->where('country_id', $user->country_id)->orderBy('id', 'DESC')->paginate(1000);
        } else {
            $records = Order::WhereIn('status', $filtered)->where('country_id', $user->country_id)->orderBy('id', 'DESC')->paginate(1000);
        }

        //state
        //1. today
        //2. all
        return view('packaging.wrap.sent', compact('records', 'today_work', 'day'));
    }
    public function change_order_state($order, $old, $new)
    {
        OrderState::broadcast($order, $old, $new);
        $order = Order::find($order);
        $user_id = Seller::where('email', $order->shop->owner_email)->first()->id;
        $this->ordeLog($user_id, $order->id, $new);

        $order->update([
            'status' => $new
        ]);

        return redirect()->back();
    }

    public function view_update_page($order_id)
    {
        $user_id =  Auth::guard('packaging')->user()->id;

        $data = Order::find($order_id);
        $action = 'update';
        $page = 'orders';
        $pages = 'orders';
        $shopTypes = SalesChannels::find($data->sales_channel);
        $cities = City::get();
        $countries = Country::get();
        $zones = Zone::get();
        // $shops = SalesChannels::where('owner_email', $user_email)->get();
        //Today State
        $today_work_days = WorkDay::where('user_type', 'packaging')->where('user_id', $user_id)->where('completed', 0)->get();
        if (count($today_work_days) > 0) {
            $today_work = 1;
        } else {
            $today_work = 0;
        }
        $shop_orders = ProductSeller::where('shop_id', $data->shop->id)->get();
        return view('packaging.orders.control', compact('shop_orders', 'data', 'action', 'page', 'pages', 'shopTypes', 'cities', 'countries', 'zones', 'today_work'));
    }

    public function addToBoxes($state)
    {
        $user_id =  Auth::guard('packaging')->user()->id;
        //Today State
        $today_work_days = WorkDay::where('user_id', $user_id)->where('completed', 0)->get();
        if (count($today_work_days) > 0) {
            $today_work = 1;
            $work_day_id = $today_work_days[0]->id;
        } else {
            $today_work = 0;
            $work_day_id = 0;
        }
        $records = Order::where('status', 7)->get();
        //state
        //1. today
        //2. all
        return view('packaging.wrap.addToBoxes', compact('records', 'today_work'));
    }
    public function getNearestDelivery($zone_id)
    {
        $delivery = Delivery::where('zone_id', $zone_id)->where('status', 1)->first();
        if (!$delivery) {
            $zone = Zone::find($zone_id);
            if ($zone) {
                foreach (json_decode($zone->description) as $alt) {
                    $alt_user = Delivery::find($alt);
                    if ($alt_user->status == 1) {
                        return $alt_user;
                    }
                }
            }
            return 0;
        }
        return $delivery;
    }
    public function change_order_state_supporter($order, $old, $new)
    {
        OrderState::broadcast($order, $old, $new);
        $order_real = Order::find($order);
        $order_zone =  $order_real->zone_id;

        $delivery = $this->getNearestDelivery($order_zone);


        // if ($delivery) {
        //Check weather our user has work days or not
        $workDays = WorkDay::where('user_type', 'delivery')->where('user_id', $delivery->id)->get();
        if (count($workDays) == 0) {
            $work_day = WorkDay::create([
                'user_type' => 'delivery',
                'user_id' => $delivery->id,
                'started_at' => date('y-m-d H:i:s'),
                'completed' => 0,
                'finished_at' => date('y-m-d H:i:s')
            ]);
        } else {
            $work_day = $workDays[0];
        }

        WorkDayOrder::create([
            'user_user_work_day' => $work_day->id,
            'user_sales_channele_orders' => $order,
            'userType' => 'delivery',
            'userID' => $delivery->id,
            'status' => 0,
            'order_status_from' => date('y-m-d H:i:s A'),
            'order_status_to' => date('y-m-d H:i:s A')
        ]);

        $real_order = Order::find($order);
        $user_id_seller = Seller::where('email', $real_order->shop->owner_email)->first()->id;
        $this->ordeLog($user_id_seller, $real_order->id, $new);

        $order_real->update([
            'status' => $new
        ]);

        return redirect()->back();
        // } else {
        //     return redirect()->back()->with('error', 'There is no deliveries in this zone');
        // }
    }
    public function change_order_state_all($state)
    {
        $orders = Order::whereIn('status', [4, 7])->get();
        //Check weather our user has work days or not
        foreach ($orders as $order) {
            if (empty($order->zone->id))
                $zone_id = 1;
            else
                $zone_id = $order->zone->id;
            $delivery = $this->getNearestDelivery($zone_id);
            // if (!$delivery) {
            //     return redirect()->back()->with('error', 'There is no deliveries in this zone number ' . $zone_id);
            // }

            $workDays = [];
            if (is_object($delivery)) {
                $workDays = WorkDay::where('user_type', 'delivery')->where('user_id', $delivery->id)->get();
                if (count($workDays) == 0) {
                    $work_day = WorkDay::create([
                        'user_type' => 'delivery',
                        'user_id' => $delivery->id,
                        'started_at' => date('y-m-d H:i:s'),
                        'completed' => 0,
                        'finished_at' => date('y-m-d H:i:s')
                    ]);
                } else {
                    $work_day = $workDays[0];
                }
            }


            OrderState::broadcast($order->id, 7, $state);
            $user_id = Seller::where('email', $order->shop->owner_email)->first()->id;
            $this->ordeLog($user_id, $order->id, $state);

            if ($delivery) {
                WorkDayOrder::create([
                    'user_user_work_day' => $work_day->id,
                    'user_sales_channele_orders' => $order->id,
                    'userType' => 'delivery',
                    'userID' => $delivery->id,
                    'status' => 0,
                    'order_status_from' => date('y-m-d H:i:s A'),
                    'order_status_to' => date('y-m-d H:i:s A')
                ]);
                $order->update([
                    'status' => $state
                ]);
            }
        }

        return redirect()->back();
    }
    public function removeFromBox($id)
    {
        $box =  BoxOrder::find($id);
        $order_id = $box->sales_channele_order;
        $order = Order::find($order_id);
        OrderState::broadcast($order_id, $order->status, 7);
        $box->delete();
        return redirect()->back();
    }
    public function addToBox(Request  $request)
    {
        $order = $request->order;
        $old = $request->old;
        $new = $request->new;
        BoxOrder::create([
            'box_id' => $request->box_id,
            'sales_channele_order' => $order,
        ]);
        OrderState::broadcast($order, $old, $new);
        $order = Order::find($order);
        $order->update([
            'status' => $new
        ]);
        return redirect()->back();
    }
    public function BoxStatusChange($id, $state)
    {
        $box = Box::find($id);
        if ($state == 1) {
            $box->update([
                'status' => 0
            ]);
        } else {
            $box->update([
                'status' => 1
            ]);
        }
        return redirect()->back();
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
        $order = OrderProduct::find($id);
        if ($request->products_id) {
            $products_number = count($request->products_id) - 1;
            $old_orders = OrderProduct::where('sales_channele_order', $id)->get();
            foreach ($old_orders as $old) {
                $old->delete();
            }
            for ($i = 0; $i < $products_number; $i++) {
                OrderProduct::create([
                    'sales_channele_order' => $id,
                    'product_id' => $request->products_id[$i],
                    'amount' => $request->products_amount[$i],
                    'price' => $request->products_price[$i],
                    'delivery_date' => $request->delivery_date
                ]);
            }
        }
        $real_order = Order::find($id);
        if ($request->notes) {
            $notes = $request->notes;
        } else {
            $notes = $real_order->notes;
        }

        if ($request->city_id) {
            $city_id = $request->city_id;
        } else {
            $city_id = $real_order->city_id;
        }

        if ($request->zone_id) {
            $zone_id = $request->zone_id;
        } else {
            $zone_id = $real_order->zone_id;
        }

        if ($request->district_id) {
            $district_id = $request->district_id;
        } else {
            $district_id = $real_order->district_id;
        }

        if ($request->customer_address) {
            $customer_address = $request->customer_address;
        } else {
            $customer_address = $real_order->customer_address;
        }

        if ($request->delivery_date) {
            $delivery_date = $request->delivery_date;
        } else {
            $delivery_date = $real_order->delivery_date;
        }

        $real_order->update([
            'notes' => $notes,
            'city_id' => $city_id,
            'zone_id' => $zone_id,
            'district_id' => $district_id,
            'address' => $customer_address,
            'delivery_date' => $delivery_date

        ]);

        if ($request->change == 1) {
            $this->change_order_state($real_order->id, $real_order->status, $request->state);
        }
        return redirect()->back();
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
