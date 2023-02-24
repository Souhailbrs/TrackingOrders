<?php

namespace App\Http\Controllers\Supporter;

use App\Events\OrderState;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderContact;
use App\Models\OrderType;
use App\Models\SalesChannels;
use App\Models\Zone;
use App\WorkDay;
use App\WorkDayOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SupporterController extends Controller
{
    public function getOrder()
    {
        $user_id = Auth::guard('supporter')->user()->id;
        $work_days = WorkDay::where('user_type', 'supporter')->where('user_id', $user_id)->where('completed', 0)->get();
        //If supporter start work or not.
        if (count($work_days) > 0) {
            $data = $this->getNextOrder();
            $action = 'update';
            $page = 'orders';
            $pages = 'orders';
            //IS There available orders!
            if ($data) {
                if (!$this->IsUserHasOrder($data)) {
                    //Take New Order
                    $data->update([
                        'status' => 1
                    ]);
                    OrderState::broadcast($data->id, $data->status, 1);
                    WorkDayOrder::create([
                        'user_user_work_day' => $work_days[0]->id,
                        'user_sales_channele_orders' => $data->id,
                        'order_status_from' => date('y-m-d H:i:s A'),
                        'order_status_to' => 0,
                        'userType' => 'supporter',
                        'userID' => $user_id,
                        'status' => 0
                    ]);

                    return $this->getCurrentOrder();

                    //return redirect()->back()->with('success','you successfully has added new order');
                } else {
                    return $this->getCurrentOrder();
                    //      return redirect()->back()->with('error','Finish your order first before taking a new one.');
                }
            } else {
                return $this->getCurrentOrder();

                //return redirect()->route('supporter.home')->with('error','There is no orders yet!');
            }
        } else {
            return redirect()->back()->with('error', 'You Have To Start Your Day');
        }
    }

    //If User Have Order Now "Available or not "

    public function getNextOrder()
    {
        // New Orders
        $New_Orders = $this->New_Orders();
        // Confirm Order at deliver day
        $Confirm_Order_at_deliver_day = $this->Confirm_Order_at_deliver_day();
        // No Answer Delivery.
        $No_Answer_Delivery = $this->No_Answer_Delivery_Orders();
        // Customer Cancelled Delivery
        //$Customer_Cancelled_callCenter= $this->Customer_Cancelled_callCenter();
        $Customer_Cancelled_callCenter = [];
        // Customer Cancelled Delivery
        $customer_cancelled_delivery = $this->Customer_Cancelled_Delivery();
        // No Answer Call Center
        $No_Answer_Call_Center = $this->No_Answer_Call_Center();
        // Not Confirmed
        $Not_Confirmed = $this->Not_Confirmed();
        $user_id = Auth::guard('supporter')->user()->id;
        $user = Auth::guard('supporter')->user();

        /*        $types = OrderType::orderBy('number', 'ASC')->where('available', 1)->where('country_id', $user->country_id)->get();*/
        $types = OrderType::orderBy('number', 'ASC')->where('available', 1)->where('country_id', $user->country_id)->get();
        $ress = [
            'New Orders' => $New_Orders,
            'No Answer Delivery' => $No_Answer_Delivery,
            'Confirm Order At Deliver Day' => $Confirm_Order_at_deliver_day,
            'Customer Cancelled Call Center' => $Customer_Cancelled_callCenter,
            'Customer Cancelled Delivery' => $customer_cancelled_delivery,
            'No Answer Call Center' => $No_Answer_Call_Center,
            'types' => $types
        ];
        $wow = [];
        foreach ($types as $type) {
            $wow[] = $ress[$type->name];
        }

        $res = [];
        foreach ($wow as $w) {
            foreach ($w as $col) {
                $res[] = $col;
            }
        }

        //$res = array_merge($New_Orders,$No_Answer_Delivery,$Customer_Cancelled_callCenter,$customer_cancelled_delivery,$Confirm_Order_at_deliver_day,$No_Answer_Call_Center);        $res =array_unique($res);
        $res = array_unique($res);
        $res = $this->callCenterOrders($res);

        if (count($res) > 0) {
            return Order::find($res[0]);
        } else {
            return 0;
        }
    }

    public function New_Orders()
    {
        $user_id = Auth::guard('supporter')->user()->id;

        $orders_no_answer_delivery = Order::where('status', 0)->where('deleted', 0)->get();
        $ids = [];
        foreach ($orders_no_answer_delivery as $record) {
            $ids[] = $record->id;
        }
        $orders_no_answer_delivery_new = $this->IsCallCenterOrders($ids, $user_id);

        return $orders_no_answer_delivery_new;
    }

    public function IsCallCenterOrders($orders_ids, $supporter_id)
    {
        $res = [];
        foreach ($orders_ids as $order_id) {
            $exist = OrderContact::where('sale_channele_order_id', $order_id)->where('userType', 'supporter')->where('user_id', $supporter_id)->first();
            if ($exist) {
                if ($exist->order->country_id == Auth::guard('supporter')->user()->country_id) {
                    $res[] = $exist->order->id;
                }
            } else {
                $existx = Order::find($order_id);
                if (isset($existx->country_id) &&  Auth::guard('supporter')->user()->country_id == $existx->shop->country_id) {
                    $res[] = $existx->id;
                }
            }
        }
        return $res;
    }

    public function Confirm_Order_at_deliver_day()
    {
        $user_id = Auth::guard('supporter')->user()->id;
        //Delivery date
        //Confirmed date
        $orders_no_answer_delivery = Order::whereIn('status', [4, 7])->where('delivery_date', '=', Carbon::today())->where('deleted', 0)->get();
        $orders_no_answer_delivery_new = [];
        foreach ($orders_no_answer_delivery as $record) {
            $exist = OrderContact::whereIn('status', [4, 7])->where('sale_channele_order_id', $record->id)->where('userType', 'supporter')->where('user_id', $user_id)->get();

            //If creation date is equal to delivery date or less than one
            //ignore
            //Otherwise
            //Call Him.
            foreach ($exist as $ex) {
                $contact_before = date('Y-m-d', strtotime($ex->created_at));
                $delivery_date = $record->delivery_date;
                $limit = date('Y-m-d', strtotime($contact_before . ' + 2 day'));
                //12
                //13
                //14
                //15
                $res = [
                    'limit' => $limit,
                    'delivery_date' => $delivery_date,
                    'contact_before' => $contact_before
                ];
                // dd($res);
                if ($limit > $delivery_date) {
                    //Ignore
                    continue;
                } elseif ($limit <= $delivery_date) {
                    //Contact 12
                    //Deliver 12 or 13 //ignore
                    //otherwise
                    //takeId
                    $orders_no_answer_delivery_new[] = $record->id;
                } else {
                    //Ignore Same Day
                    continue;
                }

                $orders_no_answer_delivery_new[] = $record->id;
            }


            $orders_no_answer_delivery_new = array_unique($orders_no_answer_delivery_new);
        }
        $orders_no_answer_delivery_new = $this->IsCallCenterOrders($orders_no_answer_delivery_new, $user_id);

        return $orders_no_answer_delivery_new;
    }

    public function No_Answer_Delivery_Orders()
    {
        $user_id = Auth::guard('supporter')->user()->id;
        $orders_no_answer_delivery = Order::where('status', 12)->where('deleted', 0)->get();
        $orders_no_answer_delivery_new = [];
        foreach ($orders_no_answer_delivery as $record) {
            $exist = OrderContact::where('status', 12)->where('sale_channele_order_id', $record->id)->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->get();
            if (count($exist) < 2) {
                if (count($exist) < 1) {
                    $orders_no_answer_delivery_new[] = $record->id;
                } else {
                    if (date('Y-m-d-H:i:s', strtotime($exist[0]->updated_at)) < date('Y-m-d H:i:s', strtotime('-4 Hours'))) {
                        $orders_no_answer_delivery_new[] = $record->id;
                    }
                }
            }
        }
        $orders_no_answer_delivery_new = $this->IsCallCenterOrders($orders_no_answer_delivery_new, $user_id);
        return $orders_no_answer_delivery_new;
    }

    public function Customer_Cancelled_Delivery()
    {
        $user_id = Auth::guard('supporter')->user()->id;

        $orders_no_answer_delivery = Order::where('status', 11)->where('deleted', 0)->get();
        $orders_no_answer_delivery_new = [];
        foreach ($orders_no_answer_delivery as $record) {
            $exist = OrderContact::where('status', 11)->where('sale_channele_order_id', $record->id)->get();
            if (count($exist) <= 0) {
                $orders_no_answer_delivery_new[] = $record->id;
            }
        }
        $orders_no_answer_delivery_new = $this->IsCallCenterOrders($orders_no_answer_delivery_new, $user_id);

        return $orders_no_answer_delivery_new;
    }

    public function No_Answer_Call_Center()
    {
        $user_id = Auth::guard('supporter')->user()->id;
        $orders_no_answer_delivery = Order::where('status', 2)->where('deleted', 0)->get();
        $orders_no_answer_delivery_new = [];
        foreach ($orders_no_answer_delivery as $record) {
            $exist = OrderContact::where('status', 2)->where('sale_channele_order_id', $record->id)->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->where('userType', 'supporter')->where('user_id', $user_id)->get();
            //28.
            //1=>

            if (count($exist) < 2) {
                if (count($exist) < 1) {
                    $orders_no_answer_delivery_new[] = $record->id;
                } else {
                    // 7 Am
                    // now => 9.19 Am
                    // 7 < (9.19 - 1)
                    //7 < 8.18

                    if (date('Y-m-d h:i:sa', strtotime($exist[0]->updated_at)) < date('Y-m-d h:i:sa', strtotime('-1 Hours'))) {

                        $orders_no_answer_delivery_new[] = $record->id;
                    }
                }
            }
        }
        $orders_no_answer_delivery_new = $this->IsCallCenterOrders($orders_no_answer_delivery_new, $user_id);
        return $orders_no_answer_delivery_new;
    }

    // No Answer Delivery Orders.

    public function Not_Confirmed()
    {
        $user_id = Auth::guard('supporter')->user()->id;
        $orders_no_answer_delivery = Order::where('status', 5)->where('deleted', 0)->get();
        $orders_no_answer_delivery_new = [];
        foreach ($orders_no_answer_delivery as $record) {
            $exist = OrderContact::where('status', 5)->where('sale_channele_order_id', $record->id)->get();
            if (count($exist) < 1) {
                if (date('Y-m-d-H:i:s', strtotime($record->created_at)) < date('Y-m-d H:i:s', strtotime('-3 Days'))) {
                    $orders_no_answer_delivery_new[] = $record->id;
                }
            }
        }
        $orders_no_answer_delivery_new = $this->IsCallCenterOrders($orders_no_answer_delivery_new, $user_id);

        return $orders_no_answer_delivery_new;
    }

    // Customer Cancelled Delivery.

    public function callCenterOrders($res)
    {
        $new_res = [];
        $user = Auth::guard('supporter')->user();
        $country = Country::find($user->country_id)->id;
        if ($country) {
            foreach ($res as $r) {
                $order = Order::find($r);
                if ($order->country_id == $country) {
                    $new_res[] = $r;
                }
            }
        }
        return $new_res;
    }

    // Customer Cancelled Delivery.

    public function IsUserHasOrder($data)
    {

        $user_id = Auth::guard('supporter')->user()->id;
        $user_type = 'supporter';
        $orders = WorkDayOrder::where('user_sales_channele_orders', $data->id)->where('userType', $user_type)->where('userID', $user_id)->get();
        if (count($orders) > 0) {
            return 1;
        }
        return 0;
    }

    // Confirm Order at deliver day

    public function getCurrentOrder()
    {
        $type_users = Auth::guard('supporter')->user()->id;
        $user_email = Auth::guard('supporter')->user()->email;

        $user_type = 'supporter';
        $orders = WorkDayOrder::where('userType', $user_type)->where('userID', $type_users)->where('status', 0)->orderby('id', 'DESC')->first();
        if ($orders) {
            $order_id = $orders->user_sales_channele_orders;
            $data = Order::find($order_id);
            while ($data->deleted != 0) {
                $data = $this->getNextOrder();
            }
            $action = 'update';
            $page = 'orders';
            $pages = 'orders';
            $shopTypes = SalesChannels::find($data->sales_channel);
            $cities = City::get();
            $countries = Country::get();
            $zones = Zone::get();
            $shops = SalesChannels::where('owner_email', $user_email)->get();
            //Today State
            $today_work_days = WorkDay::where('user_type', 'supporter')->where('user_id', $type_users)->where('completed', 0)->get();
            if (count($today_work_days) > 0) {
                $today_work = 1;
            } else {
                $today_work = 0;
            }

            return view('supporter.orders.control', compact('data', 'action', 'page', 'pages', 'shopTypes', 'cities', 'countries', 'zones', 'shops', 'today_work'));
        } else {
            return redirect()->route('supporter.home', compact("type_users"))->with(['error' => 'You Dont Have any orders!']);
        }
    }

    // New Orders.


    // No Answer Call Center

    public function getAllOrders($state)
    {
        $user_id = Auth::guard('supporter')->user()->id;
        $recordsx = [];
        if ($state === 'today') {
            $recordsx = WorkDayOrder::where('userType', 'supporter')->where('userID', $user_id)->whereDate('created_at', Carbon::today())->get();
        } elseif ($state === 'all') {
            $recordsx = WorkDayOrder::where('userType', 'supporter')->where('userID', $user_id)->get();
        } else {
            return $state;
        }
        $records = [];
        foreach ($recordsx as $recx) {

            $records[] = $recx->order;
        }
        return view('supporter.orders.index', compact('records'));
    }

    // Not Confirmed

    public function Customer_Cancelled_callCenter()
    {
        $user_id = Auth::guard('supporter')->user()->id;

        $orders_no_answer_delivery = Order::where('status', 6)->where('deleted', 0)->get();
        $orders_no_answer_delivery_new = [];
        foreach ($orders_no_answer_delivery as $record) {
            $exist = OrderContact::where('status', 6)->where('sale_channele_order_id', $record->id)->where('userType', 'supporter')->where('user_id', $user_id)->get();
            if (count($exist) <= 0) {
                $orders_no_answer_delivery_new[] = $record->id;
            }
        }
        $orders_no_answer_delivery_new = $this->IsCallCenterOrders($orders_no_answer_delivery_new, $user_id);

        return $orders_no_answer_delivery_new;
    }

    public function workDays()
    {
        $user_id = Auth::guard('supporter')->user()->id;
        $work_days = WorkDay::where('user_type', 'supporter')->where('user_id', $user_id)->get()->reverse();
        $records = $work_days;

        //Today State
        $today_work_days = WorkDay::where('user_type', 'supporter')->where('user_id', $user_id)->where('completed', 0)->get();
        if (count($today_work_days) > 0) {
            $today_work = 1;
        } else {
            $today_work = 0;
        }

        return view('supporter.workdays', compact('records', 'today_work'));
    }
}
