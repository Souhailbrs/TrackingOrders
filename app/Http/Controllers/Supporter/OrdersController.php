<?php

namespace App\Http\Controllers\Supporter;

use App\Events\OrderState;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderContact;
use App\Models\OrderProduct;
use App\Models\OrderTrack;
use App\Models\OrderType;
use App\Models\SalesChannels;
use App\Models\Seller;
use App\Models\Zone;
use App\WorkDay;
use App\WorkDayOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $state, $from, $to)
    {

        $user_id = Auth::guard('supporter')->user()->id;
        $today_work_days = WorkDay::where('user_id', $user_id)->where('user_type', 'supporter')->where('completed', 0)->get();
        $work_days_order_id = WorkDayOrder::where('userID', $user_id)->where('status', 1)
            ->where('userType', 'supporter')->pluck('user_sales_channele_orders')->all();
        $work_days_orders_data
            = WorkDayOrder::where('userID', $user_id)->where('status', 1)
            ->where('userType', 'supporter')->get();

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
            $orders = Order::where('id', 'like', '%' . $search . '%')
                ->whereIn('id', $work_days_order_id)
                ->orWhere('customer_phone1', 'like', '%' . $search . '%')
                ->whereIn('id', $work_days_order_id)->pluck('id')->all();
            $workDayOrders =
                WorkDayOrder::where('user_sales_channele_orders', $orders)->where('status', 1)
                ->where('userType', 'supporter')->get();
        } else {
            $search = '';
            $workDayOrders =
                WorkDayOrder::where('userID', $user_id)->where('status', 1)
                ->where('userType', 'supporter')->get();
        }
        $work_days_orders_data = $workDayOrders;
        if ($state === 'today') {
            $workDayOrdersFilter = [];
            foreach ($work_days_orders_data as $order) {
                $order_date = date('Y-m-d', strtotime($order->created_at));
                $today = date('Y-m-d', strtotime(date('Y-m-d')));
                if ($order_date == $today) {
                    $workDayOrdersFilter[] = $order->user_sales_channele_orders;
                }
            }
        } elseif ($state == '7days') {
            $workDayOrdersFilter = [];
            foreach ($work_days_orders_data as $order) {
                $order_date = date('Y-m-d', strtotime($order->created_at));
                $today = date('Y-m-d', strtotime(date('Y-m-d') . '-7 days'));
                if ($order_date >= $today) {
                    $workDayOrdersFilter[] =  $order->user_sales_channele_orders;
                }
            }
        } elseif ($state == 'custom') {
            $workDayOrdersFilter = [];
            foreach ($work_days_orders_data as $order) {
                $order_date = date('Y-m-d', strtotime($order->created_at));
                $from = date('Y-m-d', strtotime($from));
                $to = date('Y-m-d', strtotime($to));
                if ($order_date >= $from && $order_date <= $to) {
                    $workDayOrdersFilter[] =  $order->user_sales_channele_orders;
                }
            }
        }

        $user = Auth::guard('supporter')->user();
        $country = Country::find($user->country_id)->id;
        $records = Order::whereIn('id', $workDayOrdersFilter)->where('country_id', $country)->paginate($pagination);
        return view('supporter.orders.index', compact('records', 'state', 'from', 'to', 'pagination', 'search', 'today_work'));
    }

    public function index_old($state, $from, $to)
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
        if ($state === 'today') {
            $workDayOrdersFilter = WorkDayOrder::where('userType', 'supporter')->where('user_user_work_day', $work_day_id)->where('userID', $user_id)->get();
        } elseif ($state == '7days') {
            $workDayOrders = WorkDayOrder::where('userType', 'supporter')->where('userID', $user_id)->get();
            $workDayOrdersFilter = [];
            foreach ($workDayOrders as $order) {
                $order_date = date('Y-m-d', strtotime($order->created_at));
                $today = date('Y-m-d', strtotime(date('Y-m-d') . '-7 days'));
                if ($order_date >= $today) {
                    $workDayOrdersFilter[] = $order;
                }
            }
        } elseif ($state == 'custom') {
            $workDayOrders = WorkDayOrder::where('userType', 'supporter')->where('userID', $user_id)->get();
            $workDayOrdersFilter = [];
            foreach ($workDayOrders as $order) {
                $order_date = date('Y-m-d', strtotime($order->created_at));
                $from = date('Y-m-d', strtotime($from));
                $to = date('Y-m-d', strtotime($to));

                if ($order_date >= $from && $order_date <= $to) {
                    $workDayOrdersFilter[] = $order;
                }
            }
        }
        foreach ($workDayOrdersFilter as $work) {
            $records[] = Order::find($work->user_sales_channele_orders);
        }
        //state
        //1. today
        //2. all
        return view('supporter.orders.index', compact('records', 'today_work'));
    }

    public function viewWorkDayOrders($day)
    {
        $state = 'today';
        $from = date('Y-m-d', strtotime(Carbon::yesterday()));
        $to = date('Y-m-d', strtotime(Carbon::today()));
        $search = '';
        $pagination = 20;
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
        return view('supporter.orders.index', compact('records', 'today_work', 'pagination', 'state', 'from', 'to', 'search'));
    }

    public function postDate(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        return redirect()->route('supporter.orders.index', ['state' => 'custom', 'from' => $from, 'to' => $to]);
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
    public function end_order_word($order, $old, $new)
    {
        $user_id = Auth::guard('supporter')->user()->id;

        $my_order = Order::find($order);
        if ($my_order->status != 1) {
            if ($old == 4) {
                OrderState::broadcast($order, $old, $new);
                $my_order->update([
                    'status' => $new
                ]);
                $this->ordeLog($user_id, $order, $new);
            }
        } else {
            return redirect()->back()->with('error', 'You have to change order status');
        }
        $user_id = Auth::guard('supporter')->user()->id;
        $work_days = WorkDay::where('user_type', 'supporter')->where('user_id', $user_id)->get();
        foreach ($work_days as $wk_day) {
            $id = $wk_day->id;
            $order_day = WorkDayOrder::where('user_user_work_day', $id)->where('userType', 'supporter')->where('userID', $user_id)->where('user_sales_channele_orders', $order)->get();
            foreach ($order_day as $or_day) {
                $or_day->update([
                    'status' => 1,
                    'order_status_to' => date('y-m-d h:i:s')
                ]);
            }
        }
        return $this->getOrder();

        //   return redirect()->route('supporter.home');
    }

    /*    public function getOrder(){
            $user_id =  Auth::guard('supporter')->user()->id;
            $work_days = WorkDay::where('user_type','supporter')->where('user_id',$user_id)->where('completed',0)->get();
            //If supporter start work or not.
            if(count($work_days )> 0) {
                $data = $this->getNextOrder();
                $action = 'update';
                $page = 'orders';
                $pages = 'orders';
                //IS There available orders!
                if($data){
                    if(!$this->IsUserHasOrder()){
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
                            'status' =>0
                        ]);

                        return $this->getCurrentOrder();

                        //return redirect()->back()->with('success','you successfully has added new order');
                    }else{

                        return $this->getCurrentOrder();
                        //      return redirect()->back()->with('error','Finish your order first before taking a new one.');
                    }

                }else{
                    return redirect()->route('supporter.home')->with('error','There is no orders yet!');
                }
            }else{
                return redirect()->back()->with('error','You Have To Start Your Day');
            }
        }*/
    public function getOrder()
    {

        $type_users = Auth::guard('supporter')->user()->id;
        $user_email = Auth::guard('supporter')->user()->email;
        $user_type = 'supporter';
        $user_id = Auth::guard('supporter')->user()->id;
        $user_country_id = Auth::guard('supporter')->user()->country_id;
        $work_days = WorkDay::where('user_type', 'supporter')->where('user_id', $user_id)->where('completed', 0)->get();
        $order_settings = OrderType::orderBy('number', 'asc')
            ->where('available', 1)
            ->where('country_id', $user_country_id)->get();
        //If supporter start work or not.
        if (count($work_days) > 0) {
            $orde_ids = WorkDayOrder::where('userType', 'supporter')
                ->where('user_user_work_day', $work_days[0]->id)
                ->where('userID', $user_id)
                ->pluck('user_sales_channele_orders')
                ->all();
            $current_order = null;

            foreach ($orde_ids as $id) {
                $track = OrderTrack::where('sales_channele_order', $id)->where('last_status', '!=', 1)
                    ->whereDate('created_at', '>=', $work_days[0]->created_at->format('Y-m-d'))->get();
                if (count($track) == 0) {
                    $order_infos = Order::where('id', $id)->first();
                    $current_order = $order_infos;
                }
            }

            if ($current_order == null) {
                if (count($order_settings) == 0) {
                    return redirect()->back()->with('error', 'There is no order');
                }

                $selected_order = null;
                $ids_orders_in_progress = [];
                foreach ($order_settings as $order_setting) {
                    switch ($order_setting->name) {
                        case 'New Orders': {
                                $ids_orders_in_progress = $this->getOrdersInProgressByStatus(0, $work_days);
                                if (count($ids_orders_in_progress) != 0) {
                                    $new_orders = Order::whereIn('id', $ids_orders_in_progress)->where('status', 0)->get();
                                } else {
                                    $new_orders = $this->checkOrdersIsNotInProgress(0, $user_country_id);
                                }
                                if (count($new_orders) != 0) {
                                    $selected_order = $new_orders[0];
                                }
                                break;
                            }
                        case 'No Answer Delivery': {
                                $ids_orders_in_progress = $this->getOrdersInProgressByStatus(12, $work_days);
                                if (count($ids_orders_in_progress) != 0) {
                                    $no_answer_delivery_orders = Order::whereIn('id', $ids_orders_in_progress)->where('status', 12)->get();
                                } else {
                                    $no_answer_delivery_orders = $this->checkOrdersIsNotInProgress(12, $user_country_id);
                                }
                                if (count($no_answer_delivery_orders) != 0) {
                                    $selected_order = $no_answer_delivery_orders[0];
                                }
                                break;
                            }
                        case 'Confirm Order At Deliver Day': {
                                $ids_orders_in_progress = $this->getOrdersInProgressByStatus([4, 7], $work_days);
                                if (count($ids_orders_in_progress) != 0) {
                                    $confirm_at_delivery_orders = Order::whereIn('id', $ids_orders_in_progress)->whereIn('status', [4, 7])->get();
                                } else {
                                    $confirm_at_delivery_orders = $this->checkOrdersIsNotInProgress([4, 7], $user_country_id);
                                }
                                if (count($confirm_at_delivery_orders) != 0) {
                                    $selected_order = $confirm_at_delivery_orders[0];
                                }
                                break;
                            }
                        case 'Customer Cancelled Call Center': {
                                $ids_orders_in_progress = $this->getOrdersInProgressByStatus(6, $work_days);
                                if (count($ids_orders_in_progress) != 0) {
                                    $cancelled_call_center_orders = Order::whereIn('id', $ids_orders_in_progress)->where('status', 6)->get();
                                } else {
                                    $cancelled_call_center_orders = $this->checkOrdersIsNotInProgress(6, $user_country_id);
                                }
                                if (count($cancelled_call_center_orders) != 0) {
                                    $selected_order = $cancelled_call_center_orders[0];
                                }
                                break;
                            }
                        case 'Customer Cancelled Delivery': {
                                $ids_orders_in_progress = $this->getOrdersInProgressByStatus(11, $work_days);
                                if (count($ids_orders_in_progress) != 0) {
                                    $cancelled_delivery_orders = Order::whereIn('id', $ids_orders_in_progress)->where('status', 11)->get();
                                } else {
                                    $cancelled_delivery_orders = $this->checkOrdersIsNotInProgress(11, $user_country_id);
                                }
                                if (count($cancelled_delivery_orders) != 0) {
                                    $selected_order = $cancelled_delivery_orders[0];
                                }
                                break;
                            }
                        case 'No Answer Call Center': {
                                $ids_orders_in_progress = $this->getOrdersInProgressByStatus(2, $work_days);
                                if (count($ids_orders_in_progress) != 0) {
                                    $no_answer_call_center_orders = Order::whereIn('id', $ids_orders_in_progress)->where('status', 2)->get();
                                } else {
                                    $no_answer_call_center_orders = $this->checkOrdersIsNotInProgress(2, $user_country_id);
                                }
                                if (count($no_answer_call_center_orders) != 0) {
                                    $selected_order = $no_answer_call_center_orders[0];
                                }
                                break;
                            }
                    }
                    if ($selected_order != null) {
                        break;
                    }
                }
                if ($selected_order == null) {
                    if (count($ids_orders_in_progress) != 0) {
                        $not_confirmed_orders = Order::whereIn('id', $ids_orders_in_progress)->whereIn('status', 5)->get();
                    } else {
                        $not_confirmed_orders = $this->checkOrdersIsNotInProgress(5, $user_country_id);
                    }
                    if (count($not_confirmed_orders) != 0) {
                        $selected_order = $not_confirmed_orders[0];
                    }
                }
            } else {
                $selected_order = $current_order;
            }


            if ($selected_order != null) {
                $data = $selected_order;
                $action = 'update';
                $page = 'orders';
                $pages = 'orders';
                $shopTypes = SalesChannels::find($data->sales_channel);
                $cities = City::get();
                $countries = Country::get();
                $zones = Zone::get();
                $shops = SalesChannels::where('owner_email', $user_email)->get();
                if ($current_order == null) {
                    $order_in_workdayorders = WorkDayOrder::where('user_sales_channele_orders', $data->id)->get();
                    if (count($order_in_workdayorders) == 0) {
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
                    }
                }
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
            // $data = $this->getNextOrder();
            // $action = 'update';
            // $page = 'orders';
            // $pages = 'orders';
            // //IS There available orders!
            // if ($data) {
            //     if (!$this->IsUserHasOrder($data)) {
            //         //Take New Order
            //         $data->update([
            //             'status' => 1
            //         ]);
            //         OrderState::broadcast($data->id, $data->status, 1);
            //         WorkDayOrder::create([
            //             'user_user_work_day' => $work_days[0]->id,
            //             'user_sales_channele_orders' => $data->id,
            //             'order_status_from' => date('y-m-d H:i:s A'),
            //             'order_status_to' => 0,
            //             'userType' => 'supporter',
            //             'userID' => $user_id,
            //             'status' => 0
            //         ]);

            //         return $this->getCurrentOrder();

            //         //return redirect()->back()->with('success','you successfully has added new order');
            //     } else {
            //         return $this->getCurrentOrder();
            //         //      return redirect()->back()->with('error','Finish your order first before taking a new one.');
            //     }
            // } else {
            //     return $this->getCurrentOrder();

            //     //return redirect()->route('supporter.home')->with('error','There is no orders yet!');
            // }
        }
        if (count($work_days) == 0) {
            return redirect()->back()->with('error', 'You Have To Start Your Day');
        }
    }

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

        /*        $types = OrderType::orderBy('number', 'ASC')->where('available', 1)->where('country_id', $user_id->country_id)->get();*/
        $types = OrderType::orderBy('number', 'ASC')->where('available', 1)->get();

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

        // $res = array_merge($New_Orders,$No_Answer_Delivery,$Customer_Cancelled_callCenter,$customer_cancelled_delivery,$Confirm_Order_at_deliver_day,$No_Answer_Call_Center);
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

    public function Confirm_Order_at_deliver_day()
    {
        $user_id = Auth::guard('supporter')->user()->id;
        //Delivery date
        //Confirmed date
        $orders_no_answer_delivery = Order::where('status', 7)->where('delivery_date', '=', Carbon::today())->where('deleted', 0)->get();
        $orders_no_answer_delivery_new = [];
        foreach ($orders_no_answer_delivery as $record) {
            $exist = OrderContact::where('status', 4)->where('sale_channele_order_id', $record->id)->where('userType', 'supporter')->where('user_id', $user_id)->get();

            //If creation date is equal to delivery date or less than one
            //ignore
            //Otherwise
            //Call Him.
            foreach ($exist as $ex) {
                $contact_before = date('Y-m-d', strtotime($ex->created_at));
                $delivery_date = $record->delivery_date;
                $limit = date('Y-m-d', strtotime($contact_before . ' + 2 day'));
                $today = date('Y-m-d');

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
                } elseif ($today == $delivery_date) {
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

    // No Answer Delivery Orders.

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

    // Customer Cancelled Delivery.

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

    // Customer Cancelled Delivery.

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

    // Confirm Order at deliver day

    public function No_Answer_Call_Center()
    {
        $user_id = Auth::guard('supporter')->user()->id;
        $orders_no_answer_delivery = Order::whereIn('status', 2)->where('deleted', 0)->get();
        $orders_no_answer_delivery_new = [];
        foreach ($orders_no_answer_delivery as $record) {
            $exist = OrderContact::where('status', 2)->where('sale_channele_order_id', $record->id)->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->where('userType', 'supporter')->where('user_id', $user_id)->get();
            if (count($exist) < 2) {
                if (count($exist) < 1) {
                    $orders_no_answer_delivery_new[] = $record->id;
                } else {

                    if (date('Y-m-d h:i:sa', strtotime($exist[0]->updated_at)) < date('Y-m-d h:i:sa', strtotime('-1 Hours'))) {

                        $orders_no_answer_delivery_new[] = $record->id;
                    }
                }
            }
        }
        $orders_no_answer_delivery_new = $this->IsCallCenterOrders($orders_no_answer_delivery_new, $user_id);
        return $orders_no_answer_delivery_new;
    }

    // New Orders.

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

    // No Answer Call Center

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

    // Not Confirmed

    public function IsUserHasOrder()
    {
        $user_id = Auth::guard('supporter')->user()->id;
        $user_type = 'supporter';
        $orders = WorkDayOrder::where('userType', $user_type)->where('userID', $user_id)->where('status', 0)->get();
        if (count($orders) > 0) {
            return 1;
        }
        return 0;
    }

    //If User Have Order Now "Available or not "

    public function getCurrentOrder()
    {
        $user_id = Auth::guard('supporter')->user()->id;
        $user_email = Auth::guard('supporter')->user()->email;

        $user_type = 'supporter';
        $orders = WorkDayOrder::where('userType', $user_type)->where('userID', $user_id)->where('status', 0)->first();
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
            $today_work_days = WorkDay::where('user_type', 'supporter')->where('user_id', $user_id)->where('completed', 0)->get();
            if (count($today_work_days) > 0) {
                $today_work = 1;
            } else {
                $today_work = 0;
            }
            return view('supporter.orders.control', compact('data', 'action', 'page', 'pages', 'shopTypes', 'cities', 'countries', 'zones', 'shops', 'today_work'));
        } else {
            return redirect()->route('supporter.home')->with('error', 'You Dont Have any orders!');
        }
    }

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
        if ($request->country_id) {
            $country_id = $request->country_id;
        } else {
            $country_id = $real_order->country_id;
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
        if ($request->cancelled_order) {
            $notes = "الغي بسبب" . " " . $notes;
        }
        $real_order->update([
            'notes' => $notes,
            'city_id' => $city_id,
            'zone_id' => $zone_id,
            'district_id' => $district_id,
            'address' => $customer_address,
            'delivery_date' => $delivery_date

        ]);
        if ($request->state) {
            return $this->change_order_state($real_order->id, $real_order->status, $request->state);
        } else {
            return redirect()->route('supporter.getOrder');
        }
    }

    public function change_order_state($order_id, $old, $new)
    {
        $user_id = Auth::guard('supporter')->user()->id;
        OrderContact::create([
            'sale_channele_order_id' => $order_id,
            'times' => 1,
            'status' => $new,
            'user_id' => $user_id,
            'userType' => 'supporter',
        ]);
        OrderState::broadcast($order_id, $old, $new);
        $order = Order::find($order_id);
        switch ($new) {
            case 2: {
                    $no_answer_order = OrderTrack::where('sales_channele_order', $order_id)->where('last_status', 2)->get();
                    if (count($no_answer_order) > 6) {
                        $order->update([
                            'status' => 6
                        ]);
                        OrderTrack::create([
                            'sales_channele_order' => $order_id,
                            'old_status' => $old,
                            'last_status' => 6,
                        ]);
                    } else {

                        $order->update([
                            'status' => $new
                        ]);
                    }
                    break;
                }
            case 5: {
                    $not_confirmed_order = OrderTrack::where('sales_channele_order', $order_id)->where('last_status', 5)->get();
                    if (count($not_confirmed_order) > 2) {
                        $order->update([
                            'status' => 6
                        ]);
                        OrderTrack::create([
                            'sales_channele_order' => $order_id,
                            'old_status' => $old,
                            'last_status' => 6,
                        ]);
                    } else {
                        $order->update([
                            'status' => $new
                        ]);
                    }
                    break;
                }
            case 12: {
                    $no_answer_delivery_order = OrderTrack::where('sales_channele_order', $order_id)->where('last_status', 12)->get();
                    if (count($no_answer_delivery_order) > 2) {
                        $order->update([
                            'status' => 6
                        ]);
                        OrderTrack::create([
                            'sales_channele_order' => $order_id,
                            'old_status' => $old,
                            'last_status' => 6,
                        ]);
                    } else {
                        if ($new == 2) {
                            $order->update([
                                'status' => 12
                            ]);
                        } else {
                            $order->update([
                                'status' => $new
                            ]);
                        }
                    }
                    break;
                }
            case 9: {
                    $no_answer_delivery_order = OrderTrack::where('sales_channele_order', $order_id)->where('last_status', 9)->get();
                    if (count($no_answer_delivery_order) > 1) {
                        $order->update([
                            'status' => 6
                        ]);
                        OrderTrack::create([
                            'sales_channele_order' => $order_id,
                            'old_status' => $old,
                            'last_status' => 6,
                        ]);
                    } else {
                        $order->update([
                            'status' => $new
                        ]);
                    }
                    break;
                }
            default:
                $order->update([
                    'status' => $new
                ]);
                break;
        }

        $user_id_seller = Seller::where('email', $order->shop->owner_email)->first()->id;
        $this->ordeLog($user_id_seller, $order->id, $new);
        return redirect()->route('supporter.getOrder');
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
