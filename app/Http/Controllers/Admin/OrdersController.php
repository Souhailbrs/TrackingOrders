<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderContact;
use App\Models\OrderLog;
use App\Models\OrderProduct;
use App\Models\OrderTrack;
use App\Models\OrderType;
use App\Models\ProductSeller;
use App\WorkDay;
use App\WorkDayOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use orders;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, $state, $from, $to)
    {

        if ($request->entries) {
            $pagination = $request->entries;
        } else {
            $pagination = 20;
        }
        if ($request->search) {
            $search = $request->search;

            $workDayOrders = Order::where('id', 'like', '%' . $search . '%')->orWhere('customer_phone1', 'like', '%' . $search . '%')->get();

            $total_orders = count($workDayOrders);
        } else {
            $search = '';
            $workDayOrders = Order::get();
            $total_orders = count(Order::get());
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

        if ($request->country_id) {
            if ($request->status) {
                $records = Order::whereIn('id', $workDayOrdersFilter)->where('status', $request->status)->where('country_id', $request->country_id)->paginate($pagination);
            } else {
                $records = Order::whereIn('id', $workDayOrdersFilter)->where('country_id', $request->country_id)->paginate($pagination);
            }
        } else {
            if ($request->status != 'all' && !empty($request->status)) {
                if ($pagination <= 1000)
                    $records = Order::whereIn('id', $workDayOrdersFilter)->where('status', $request->status)->paginate($pagination);
                else
                    $records = Order::whereIn('id', $workDayOrdersFilter)->where('status', $request->status)->paginate(1000);
            } else {
                if ($pagination <= 1000)
                    $records = Order::whereIn('id', $workDayOrdersFilter)->paginate($pagination);
                else
                    $records = Order::whereIn('id', $workDayOrdersFilter)->paginate(1000);
            }
        }
        return view('admin.orders.index', compact('records', 'state', 'total_orders', 'from', 'to', 'pagination', 'search'));
    }

    public function viewWorkDayOrders($day)
    {
        $user_id = Auth::guard('supporter')->user()->id;
        //Today State
        $today_work_days = WorkDay::where('user_id', $user_id)->where('user_type', 'supporter')->where('completed', 0)->get();
        if (count($today_work_days) > 0) {
            $today_work = 1;
            $work_day_id = $today_work_days[0]->id;
        } else {
            $today_work = 0;
            $work_day_id = 0;
        }
        $records = [];

        $work_day = WorkDay::find($day);
        $records_old = $work_day->day_orders;

        foreach ($records_old as $rec) {
            $records[] = $rec->order;
        }
        return view('supporter.orders.index', compact('records', 'today_work'));
    }

    public function postDate(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        return redirect()->route('admin.orders.index', ['state' => 'custom', 'from' => $from, 'to' => $to]);
    }

    public function deleteOders(Request $request)
    {
        $fromDeleted = $request->fromDeleted;
        $toDeleted = $request->toDeleted;
        if (empty($fromDeleted) || empty($toDeleted)) {
            return redirect()->back()->with('error', 'Couldnt delete orders choose a date from and to and retry!');
        }
        $orders = Order::whereBetween('created_at', [$fromDeleted, $toDeleted])->get();
        if (count($orders) == 0) {
            return redirect()->back()->with('error', 'There is no orders in this date range!');
        }
        foreach ($orders as $order) {
            WorkDayOrder::where('user_sales_channele_orders', $order->id)->delete();
            OrderTrack::where('sales_channele_order', $order->id)->delete();
            OrderContact::where('sale_channele_order_id', $order->id)->delete();
            OrderLog::where('order_id', $order->id)->delete();
            OrderProduct::where('sales_channele_order', $order->id)->delete();
            Order::where('id', $order->id)->delete();
        }
        return redirect()->back()->with('success', 'Orders have been deleted succefully!');
    }

    public function UpdateSettings(Request $request)
    {
        $numbers = $request->numbers;
        $ids = $request->ids;
        $available = [];
        for ($i = 0; $i < count($ids); $i++) {
            if ($request['available_' . $ids[$i]]) {
                $available[] = 1;
            } else {
                $available[] = 0;
            }
        }

        for ($i = 0; $i < count($ids); $i++) {
            $type = OrderType::find($ids[$i]);
            $type->update([
                'number' => $numbers[$i],
                'available' => $available[$i],
            ]);
        }

        return redirect()->back()->with('success', 'Done Successfully');
    }

    public function viewSettingsCountries()
    {
        $records = Country::get();
        return view('admin.settings.orders.countries', compact('records'));
    }

    public function viewSettings($country)
    {
        $country_details = Country::find($country);
        $orders = [
            'New Orders',
            'No Answer Delivery',
            'Confirm Order At Deliver Day',
            'Customer Cancelled Call Center',
            'Customer Cancelled Delivery',
            'No Answer Call Center',
        ];
        $records = OrderType::where('country_id', $country)->get();
        if (!count($records) > 0) {
            for ($i = 0; $i < count($orders); $i++) {
                OrderType::create([
                    'name' => $orders[$i],
                    'number' => $i,
                    'available' => 1,
                    'country_id' => $country
                ]);
            }
        }
        $records = OrderType::where('country_id', $country)->get();

        return view('admin.settings.orders.control', compact('records', 'country_details'));
    }

    public function chnageProductStatus($id)
    {
        $exist = ProductSeller::find($id);
        if ($exist) {
            if ($exist->status == 1) {
                $exist->update(['status' => 0]);
            } else {
                $exist->update(['status' => 1]);
            }
        }
        return redirect()->back()->with('success', 'Done Successfully');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.inventory.create');
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
