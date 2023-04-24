<?php

namespace App\Http\Controllers\Supporter;

use App\Events\OrderState;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HelperController;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderContact;
use App\Models\OrderLog;
use App\Models\OrderTrack;
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
    public function checkOrdersIsNotInProgress($status, $country_id)
    {
        $orders = WorkDayOrder::where('userType', 'supporter')
            ->pluck('user_sales_channele_orders')->all();
        if (is_array($status)) {
            $result = Order::whereNotIn('id', $orders)
                ->where('country_id', $country_id)
                ->whereIn('status', $status)
                ->get();
        } else {
            $result = Order::whereNotIn('id', $orders)
                ->where('country_id', $country_id)
                ->where('status', $status)
                ->get();
        }
        return $result;
    }
    public function getOrdersInProgressByStatus($status, $work_days, $country_id)
    {
        $ids_orders_in_progress = [];
        if ($status == 2 || $status == 5 || $status == 12 || $status == 11) {
            $ids_orders_in_progress_by_other_supp =
                WorkDayOrder::whereDate('created_at', Carbon::now()->format('Y-m-d'))
                ->pluck('user_sales_channele_orders')->all();
            $order_id = Order::where('status', $status)
                ->whereNotIn('id', $ids_orders_in_progress_by_other_supp)
                ->where('country_id', $country_id)
                ->pluck('id')->all();
            $ids_orders_in_progress[] = $order_id;
        } else {
            $orders_already_in_progress = WorkDayOrder::where('status', 0)->where('user_user_work_day', $work_days[0]->id)->get();
            if (is_array($status)) {
                if (count($orders_already_in_progress) != 0) {
                    foreach ($orders_already_in_progress as $order) {
                        $order_id = Order::where('id', $order->user_sales_channele_orders)
                            ->where('country_id', $country_id)
                            ->whereIn('status', $status)->pluck('id')->all();
                        if (empty($order_id)) {
                            $ids_orders_in_progress[] = $order_id;
                        }
                    }
                }
            } else {
                if (count($orders_already_in_progress) != 0) {
                    foreach ($orders_already_in_progress as $order) {
                        $order_id = Order::where('id', $order->user_sales_channele_orders)
                            ->where('status', $status)->where('country_id', $country_id)->pluck('id')->all();
                        if (empty($order_id)) {
                            $ids_orders_in_progress[] = $order_id;
                        }
                    }
                }
            }
        }
        $ids_orders_in_progress = array_filter($ids_orders_in_progress);
        return $ids_orders_in_progress;
    }
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
                $track = OrderTrack::where('sales_channele_order', $id)
                    ->where('last_status', '!=', 1)
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
                                $ids_orders_in_progress = $this->getOrdersInProgressByStatus(0, $work_days, $user_country_id);
                                if (count($ids_orders_in_progress) != 0) {
                                    $new_orders = Order::whereIn('id', $ids_orders_in_progress[0])->where('status', 0)->get();
                                } else {
                                    $new_orders = $this->checkOrdersIsNotInProgress(0, $user_country_id);
                                }
                                if (count($new_orders) != 0) {
                                    $selected_order = $new_orders[0];
                                }
                                break;
                            }
                        case 'No Answer Delivery': {
                                $ids_orders_in_progress = $this->getOrdersInProgressByStatus(12, $work_days, $user_country_id);
                                if (count($ids_orders_in_progress) != 0) {
                                    $no_answer_delivery_orders = Order::whereIn('id', $ids_orders_in_progress[0])->where('status', 12)->get();
                                } else {
                                    $no_answer_delivery_orders = $this->checkOrdersIsNotInProgress(12, $user_country_id);
                                }
                                if (count($no_answer_delivery_orders) != 0) {
                                    $selected_order = $no_answer_delivery_orders[0];
                                }

                                break;
                            }
                        case 'Confirm Order At Deliver Day': {
                                $ids_orders_in_progress = $this->getOrdersInProgressByStatus([4, 7], $work_days, $user_country_id);
                                if (count($ids_orders_in_progress) != 0) {
                                    $confirm_at_delivery_orders = Order::whereIn('id', $ids_orders_in_progress[0])->whereIn('status', [4, 7])->get();
                                } else {
                                    $confirm_at_delivery_orders = $this->checkOrdersIsNotInProgress([4, 7], $user_country_id);
                                }
                                if (count($confirm_at_delivery_orders) != 0) {
                                    $selected_order = $confirm_at_delivery_orders[0];
                                }
                                break;
                            }
                        case 'Customer Cancelled Call Center': {
                                $ids_orders_in_progress = $this->getOrdersInProgressByStatus(6, $work_days, $user_country_id);
                                if (count($ids_orders_in_progress) != 0) {
                                    $cancelled_call_center_orders = Order::whereIn('id', $ids_orders_in_progress[0])->where('status', 6)->get();
                                } else {
                                    $cancelled_call_center_orders = $this->checkOrdersIsNotInProgress(6, $user_country_id);
                                }
                                if (count($cancelled_call_center_orders) != 0) {
                                    $selected_order = $cancelled_call_center_orders[0];
                                }
                                break;
                            }
                        case 'Customer Cancelled Delivery': {
                                $ids_orders_in_progress = $this->getOrdersInProgressByStatus(11, $work_days, $user_country_id);
                                if (count($ids_orders_in_progress) != 0) {
                                    $cancelled_delivery_orders = Order::whereIn('id', $ids_orders_in_progress[0])->where('status', 11)->get();
                                } else {
                                    $cancelled_delivery_orders = $this->checkOrdersIsNotInProgress(11, $user_country_id);
                                }
                                if (count($cancelled_delivery_orders) != 0) {
                                    $selected_order = $cancelled_delivery_orders[0];
                                }
                                break;
                            }
                        case 'No Answer Call Center': {
                                $ids_orders_in_progress = $this->getOrdersInProgressByStatus(2, $work_days, $user_country_id);
                                if (count($ids_orders_in_progress) != 0) {
                                    if (count($ids_orders_in_progress) == 1) {
                                        $no_answer_call_center_orders = Order::where('id', $ids_orders_in_progress)->where('status', 2)->get();
                                    } else {
                                        $no_answer_call_center_orders = Order::whereIn('id', $ids_orders_in_progress[0])->where('status', 2)->get();
                                    }
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
                // if ($selected_order == null) {
                //     if (count($ids_orders_in_progress) != 0) {
                //         $not_confirmed_orders = Order::whereIn('id', $ids_orders_in_progress)->whereIn('status', 5)->get();
                //     } else {
                //         $not_confirmed_orders = $this->checkOrdersIsNotInProgress(5, $user_country_id);
                //     }
                //     if (count($not_confirmed_orders) != 0) {
                //         $selected_order = $not_confirmed_orders[0];
                //     }
                // }

            } else {
                $selected_order = $current_order;
            }

            if ($selected_order != null) {
                $order_shown = $selected_order;
                if (is_array($order_shown)) {
                    $data = (object)$order_shown;
                } else {
                    $data = $order_shown;
                }
                $action = 'update';
                $page = 'orders';
                $pages = 'orders';
                $shopTypes = SalesChannels::find($data->sales_channel);
                $cities = City::get();
                $countries = Country::get();
                $zones = Zone::get();
                $shops = SalesChannels::where('owner_email', $user_email)->get();
                if ($current_order == null) {
                    $order_in_workdayorders = WorkDayOrder::where('user_sales_channele_orders', $data->id)->whereDate('created_at', Carbon::now()->format('Y-m-d'))->get();
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
