<?php

namespace App\Http\Controllers\Supporter;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\OrderProduct;
use App\Models\SalesChannels;
use App\Models\Seller;
use App\WorkDay;
use App\WorkDayOrder;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupporterStatisticsController extends Controller
{
    public function date_range1($first, $last, $step = '+1 day', $output_format = 'd/m/Y')
    {

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {
            array_push($dates, date($output_format, $current));
            $current = strtotime($step, $current);
        }

        return $dates;
    }
    public function index(Request $request, $type_users)
    {
        $user_id =  Auth::guard('supporter')->user()->id;
        $work_days = WorkDay::where('user_type', 'supporter')->where('user_id', $user_id)->get()->reverse();
        $records = $work_days;
        //Today State
        $today_work_days = WorkDay::where('user_type', 'supporter')->where('user_id', $user_id)->where('completed', 0)->get();
        if (count($today_work_days) > 0) {
            $today_work = 1;
        } else {
            $today_work = 0;
        }
        //Date that can be
        //All Days
        //Today
        //From to
        if (!$request->date) {
            $date_input = 'all';
        } else {
            $date_input = $request->date;
        }
        if (!$request->country) {
            $country = '1';
        } else {
            $country = $request->country;
        }
        if (!$request->city) {
            $city = '!';
        } else {
            $city = $request->city;
        }
        $current_country = Country::where('id', $country)->pluck('currency_symbol')->all();
        //get values of all orders
        $current_year = Carbon::now()->format('Y');
        $current_month = Carbon::now()->format('M');
        $yValues = [];
        $xValues = [];
        $months = [];
        $total_per_months = [];
        $total_earnings = 0;
        switch ($date_input) {
            case 'today': {
                    $sales = WorkDayOrder::where('userID', $type_users)
                        ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))
                        ->where('status', 1)->pluck('user_sales_channele_orders')->all();
                    $all_orders = [];
                    $new_orders = [];
                    $confirmed_orders = [];
                    $delivered_orders = [];
                    $no_answer_orders = [];
                    $not_confirmed_orders = [];
                    $canceled_orders = [];
                    $monthsname = [];
                    $total_earnings = 0;
                    foreach ($sales as $sales_all) {
                        $result_all_orders  = Order::where('id', $sales_all)->where('country_id', $country)->get()->toArray();
                        $result_new_orders = Order::where('id', $sales_all)->where('status', 0)->where('country_id', $country)->get()->toArray();
                        $result_confirmed_orders = Order::where('id', $sales_all)->where('status', 4)->get()->toArray();
                        $result_delivered_orders = Order::where('id', $sales_all)->where('status', 10)->get()->toArray();
                        $result_no_answer_orders = Order::where('id', $sales_all)->where('country_id', $country)->whereIn('status', [2, 3, 12])->get()->toArray();
                        $result_not_confirmed_orders = Order::where('id', $sales_all)->where('country_id', $country)->where('status', 5)->get()->toArray();
                        $result_canceled_orders = Order::where('id', $sales_all)->where('country_id', $country)->whereIn('status', [6, 9, 11, 13])->get()->toArray();

                        $all_orders = array_merge($all_orders, $result_all_orders);
                        $new_orders = array_merge($result_new_orders, $new_orders);
                        $confirmed_orders = array_merge($result_confirmed_orders, $confirmed_orders);
                        $delivered_orders = array_merge($result_delivered_orders, $delivered_orders);
                        $no_answer_orders = array_merge($result_no_answer_orders, $no_answer_orders);
                        $not_confirmed_orders = array_merge($result_not_confirmed_orders, $not_confirmed_orders);
                        $canceled_orders = array_merge($result_canceled_orders, $canceled_orders);
                    }
                    break;
                }
            case 'yesterday': {
                    $sales = WorkDayOrder::where('userID', $type_users)
                        ->whereDate('created_at', '=', Carbon::yesterday()->format('Y-m-d'))
                        ->where('status', 1)->pluck('user_sales_channele_orders')->all();
                    $all_orders = [];
                    $new_orders = [];
                    $confirmed_orders = [];
                    $delivered_orders = [];
                    $no_answer_orders = [];
                    $not_confirmed_orders = [];
                    $canceled_orders = [];
                    $monthsname = [];
                    $total_earnings = 0;
                    foreach ($sales as $sales_all) {
                        $result_all_orders  = Order::where('id', $sales_all)->where('country_id', $country)->get()->toArray();
                        $result_new_orders = Order::where('id', $sales_all)->where('status', 0)->where('country_id', $country)->get()->toArray();
                        $result_confirmed_orders = Order::where('id', $sales_all)->where('status', 4)->get()->toArray();
                        $result_delivered_orders = Order::where('id', $sales_all)->where('status', 10)->get()->toArray();
                        $result_no_answer_orders = Order::where('id', $sales_all)->where('country_id', $country)->whereIn('status', [2, 3, 12])->get()->toArray();
                        $result_not_confirmed_orders = Order::where('id', $sales_all)->where('country_id', $country)->where('status', 5)->get()->toArray();
                        $result_canceled_orders = Order::where('id', $sales_all)->where('country_id', $country)->whereIn('status', [6, 9, 11, 13])->get()->toArray();

                        $all_orders = array_merge($all_orders, $result_all_orders);
                        $new_orders = array_merge($result_new_orders, $new_orders);
                        $confirmed_orders = array_merge($result_confirmed_orders, $confirmed_orders);
                        $delivered_orders = array_merge($result_delivered_orders, $delivered_orders);
                        $no_answer_orders = array_merge($result_no_answer_orders, $no_answer_orders);
                        $not_confirmed_orders = array_merge($result_not_confirmed_orders, $not_confirmed_orders);
                        $canceled_orders = array_merge($result_canceled_orders, $canceled_orders);
                    }
                    break;
                    break;
                }
            case '7days': {
                    $filter_date = Carbon::now()->subDays(7);
                    $sales = WorkDayOrder::where('userID', $type_users)
                        ->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))
                        ->where('status', 1)->pluck('user_sales_channele_orders')->all();
                    $all_orders = [];
                    $new_orders = [];
                    $confirmed_orders = [];
                    $delivered_orders = [];
                    $no_answer_orders = [];
                    $not_confirmed_orders = [];
                    $canceled_orders = [];
                    $monthsname = [];
                    $total_earnings = 0;
                    foreach ($sales as $sales_all) {
                        $result_all_orders  = Order::where('id', $sales_all)->where('country_id', $country)->get()->toArray();
                        $result_new_orders = Order::where('id', $sales_all)->where('status', 0)->where('country_id', $country)->get()->toArray();
                        $result_confirmed_orders = Order::where('id', $sales_all)->where('status', 4)->get()->toArray();
                        $result_delivered_orders = Order::where('id', $sales_all)->where('status', 10)->get()->toArray();
                        $result_no_answer_orders = Order::where('id', $sales_all)->where('country_id', $country)->whereIn('status', [2, 3, 12])->get()->toArray();
                        $result_not_confirmed_orders = Order::where('id', $sales_all)->where('country_id', $country)->where('status', 5)->get()->toArray();
                        $result_canceled_orders = Order::where('id', $sales_all)->where('country_id', $country)->whereIn('status', [6, 9, 11, 13])->get()->toArray();

                        $all_orders = array_merge($all_orders, $result_all_orders);
                        $new_orders = array_merge($result_new_orders, $new_orders);
                        $confirmed_orders = array_merge($result_confirmed_orders, $confirmed_orders);
                        $delivered_orders = array_merge($result_delivered_orders, $delivered_orders);
                        $no_answer_orders = array_merge($result_no_answer_orders, $no_answer_orders);
                        $not_confirmed_orders = array_merge($result_not_confirmed_orders, $not_confirmed_orders);
                        $canceled_orders = array_merge($result_canceled_orders, $canceled_orders);
                    }
                    $days = array();
                    array_push($days, date('l', strtotime($filter_date)));
                    $total_per_days = [];
                    for ($i = 0; $i < 7; $i++) {
                        $total_earnings = 0;
                        $delivered_orders_per_month = Order::whereIn('id', $sales)
                            ->whereYear('created_at', '=', $current_year)
                            ->whereMonth('created_at', '=', date('m', strtotime($filter_date)))
                            ->whereDay('created_at', '=', date('d', strtotime($filter_date)))
                            ->where('country_id', $country)->where('status', 10)->get();
                        foreach ($delivered_orders_per_month as $order) {
                            $id = $order->id;
                            $prices = OrderProduct::where('sales_channele_order', $id)->pluck('price')->all();
                            $amounts = OrderProduct::where('sales_channele_order', $id)->pluck('amount')->all();
                            foreach ($prices as $price) {
                                foreach ($amounts as $amount) {
                                    $total = $amount * $price;
                                }
                            }
                            $total_earnings += $total;
                        }
                        array_push($total_per_days, $total_earnings);
                        $filter_date = date('d.m.Y', strtotime($filter_date . ' + 1 days'));
                        array_push($days, date('l', strtotime($filter_date)));
                    }
                    $yValues = $total_per_days;
                    $xValues = $days;
                    break;
                }
            case '30days': {
                    $filter_date = Carbon::now()->subDays(30);
                    $sales = WorkDayOrder::where('userID', $type_users)
                        ->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))
                        ->where('status', 1)->pluck('user_sales_channele_orders')->all();
                    $all_orders = [];
                    $new_orders = [];
                    $confirmed_orders = [];
                    $delivered_orders = [];
                    $no_answer_orders = [];
                    $not_confirmed_orders = [];
                    $canceled_orders = [];
                    $monthsname = [];
                    $total_earnings = 0;
                    foreach ($sales as $sales_all) {
                        $result_all_orders  = Order::where('id', $sales_all)->where('country_id', $country)->get()->toArray();
                        $result_new_orders = Order::where('id', $sales_all)->where('status', 0)->where('country_id', $country)->get()->toArray();
                        $result_confirmed_orders = Order::where('id', $sales_all)->where('status', 4)->get()->toArray();
                        $result_delivered_orders = Order::where('id', $sales_all)->where('status', 10)->get()->toArray();
                        $result_no_answer_orders = Order::where('id', $sales_all)->where('country_id', $country)->whereIn('status', [2, 3, 12])->get()->toArray();
                        $result_not_confirmed_orders = Order::where('id', $sales_all)->where('country_id', $country)->where('status', 5)->get()->toArray();
                        $result_canceled_orders = Order::where('id', $sales_all)->where('country_id', $country)->whereIn('status', [6, 9, 11, 13])->get()->toArray();

                        $all_orders = array_merge($all_orders, $result_all_orders);
                        $new_orders = array_merge($result_new_orders, $new_orders);
                        $confirmed_orders = array_merge($result_confirmed_orders, $confirmed_orders);
                        $delivered_orders = array_merge($result_delivered_orders, $delivered_orders);
                        $no_answer_orders = array_merge($result_no_answer_orders, $no_answer_orders);
                        $not_confirmed_orders = array_merge($result_not_confirmed_orders, $not_confirmed_orders);
                        $canceled_orders = array_merge($result_canceled_orders, $canceled_orders);
                    }
                    $days = array();
                    array_push($days, date('d-m-Y', strtotime($filter_date)));
                    $total_per_days = [];
                    for ($i = 0; $i < 30; $i++) {
                        $total_earnings = 0;
                        $delivered_orders_per_month = Order::whereIn('id', $sales)
                            ->whereYear('created_at', '=', $current_year)
                            ->whereMonth('created_at', '=', date('m', strtotime($filter_date)))
                            ->whereDay('created_at', '=', date('d', strtotime($filter_date)))
                            ->where('country_id', $country)->where('status', 10)->get();
                        foreach ($delivered_orders_per_month as $order) {
                            $id = $order->id;
                            $prices = OrderProduct::where('sales_channele_order', $id)->pluck('price')->all();
                            $amounts = OrderProduct::where('sales_channele_order', $id)->pluck('amount')->all();
                            foreach ($prices as $price) {
                                foreach ($amounts as $amount) {
                                    $total = $amount * $price;
                                }
                            }
                            $total_earnings += $total;
                        }
                        array_push($total_per_days, $total_earnings);
                        $filter_date = date('d.m.Y', strtotime($filter_date . ' + 1 days'));
                        array_push($days, date('l', strtotime($filter_date)) . ' - ' . date('d-m-Y', strtotime($filter_date)));
                    }
                    $yValues = $total_per_days;
                    $xValues = $days;
                    break;
                }
            case 'all': {
                    $sales = WorkDayOrder::where('userID', $type_users)
                        ->whereYear('created_at', '=', $current_year)
                        ->where('status', 1)->pluck('user_sales_channele_orders')->all();
                    $total_per_months = [];
                    $all_orders = [];
                    $new_orders = [];
                    $confirmed_orders = [];
                    $delivered_orders = [];
                    $no_answer_orders = [];
                    $not_confirmed_orders = [];
                    $canceled_orders = [];
                    $monthsname = [];
                    $total_earnings = 0;
                    foreach ($sales as $sales_all) {
                        $result_all_orders  = Order::where('id', $sales_all)->where('country_id', $country)->get()->toArray();
                        $result_new_orders = Order::where('id', $sales_all)->where('country_id', $country)->where('status', 0)->get()->toArray();
                        $result_confirmed_orders = Order::where('id', $sales_all)->where('country_id', $country)->where('status', 4)->get()->toArray();
                        $result_delivered_orders = Order::where('id', $sales_all)->where('country_id', $country)->where('status', 10)->get()->toArray();
                        $result_no_answer_orders = Order::where('id', $sales_all)->where('country_id', $country)->whereIn('status', [2, 3, 12])->get()->toArray();
                        $result_not_confirmed_orders = Order::where('id', $sales_all)->where('country_id', $country)->where('status', 5)->get()->toArray();
                        $result_canceled_orders = Order::where('id', $sales_all)->where('country_id', $country)->whereIn('status', [6, 9, 11, 13])->get()->toArray();
                        $all_orders = array_merge($all_orders, $result_all_orders);
                        $new_orders = array_merge($result_new_orders, $new_orders);
                        $confirmed_orders = array_merge($result_confirmed_orders, $confirmed_orders);
                        $delivered_orders = array_merge($result_delivered_orders, $delivered_orders);
                        $no_answer_orders = array_merge($result_no_answer_orders, $no_answer_orders);
                        $not_confirmed_orders = array_merge($result_not_confirmed_orders, $not_confirmed_orders);
                        $canceled_orders = array_merge($result_canceled_orders, $canceled_orders);
                    }

                    for ($i = 1; $i < 13; $i++) {
                        $total_earnings = 0;
                        array_push($monthsname, date('F', strtotime('01.' . $i . '.' . $current_year)));
                        $delivered_orders_per_month =
                            Order::whereIn('id', $sales)->whereYear('created_at', '=', $current_year)
                            ->whereMonth('created_at', '=', $i)->where('country_id', $country)->where('status', 10)->get();
                        foreach ($delivered_orders_per_month as $order) {
                            $id = $order->id;
                            $prices = OrderProduct::where('sales_channele_order', $id)->pluck('price')->all();
                            $amounts = OrderProduct::where('sales_channele_order', $id)->pluck('amount')->all();
                            foreach ($prices as $price) {
                                foreach ($amounts as $amount) {
                                    $total = $amount * $price;
                                }
                            }
                            $total_earnings += $total;
                        }
                        array_push($total_per_months, $total_earnings);
                    }
                    $yValues = $total_per_months;
                    $xValues = $monthsname;
                    break;
                }
            case 'from': {
                    $dateS = new Carbon($request->from);
                    $dateE = new Carbon($request->to);
                    $sales = WorkDayOrder::where('userID', $type_users)
                        ->whereBetween('created_at', [$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])
                        ->where('status', 1)->pluck('user_sales_channele_orders')->all();
                    $all_orders = [];
                    $new_orders = [];
                    $confirmed_orders = [];
                    $delivered_orders = [];
                    $no_answer_orders = [];
                    $not_confirmed_orders = [];
                    $canceled_orders = [];
                    $monthsname = [];
                    $total_earnings = 0;
                    foreach ($sales as $sales_all) {
                        $result_all_orders  = Order::where('id', $sales_all)->where('country_id', $country)->get()->toArray();
                        $result_new_orders = Order::where('id', $sales_all)->where('country_id', $country)->where('status', 0)->get()->toArray();
                        $result_confirmed_orders = Order::where('id', $sales_all)->where('country_id', $country)->where('status', 4)->get()->toArray();
                        $result_delivered_orders = Order::where('id', $sales_all)->where('country_id', $country)->where('status', 10)->get()->toArray();
                        $result_no_answer_orders = Order::where('id', $sales_all)->where('country_id', $country)->whereIn('status', [2, 3, 12])->get()->toArray();
                        $result_not_confirmed_orders = Order::where('id', $sales_all)->where('country_id', $country)->where('status', 5)->get()->toArray();
                        $result_canceled_orders = Order::where('id', $sales_all)->where('country_id', $country)->whereIn('status', [6, 9, 11, 13])->get()->toArray();

                        $all_orders = array_merge($all_orders, $result_all_orders);
                        $new_orders = array_merge($result_new_orders, $new_orders);
                        $confirmed_orders = array_merge($result_confirmed_orders, $confirmed_orders);
                        $delivered_orders = array_merge($result_delivered_orders, $delivered_orders);
                        $no_answer_orders = array_merge($result_no_answer_orders, $no_answer_orders);
                        $not_confirmed_orders = array_merge($result_not_confirmed_orders, $not_confirmed_orders);
                        $canceled_orders = array_merge($result_canceled_orders, $canceled_orders);
                    }
                    $dates = [];
                    $total_per_months = [];
                    $total_earnings = 0;
                    $dates = $this->date_range1($dateS, $dateE, "+1 day", "d.m.Y");
                    foreach ($dates as $date) {
                        $total_earnings = 0;
                        $delivered_orders_per_month = Order::whereIn('id', $sales)
                            ->whereYear('created_at', '=', date('Y', strtotime($date)))
                            ->whereMonth('created_at', '=', date('m', strtotime($date)))
                            ->whereDay('created_at', '=', date('d', strtotime($date)))
                            ->where('country_id', $country)->where('status', 10)->get();

                        foreach ($delivered_orders_per_month as $order) {
                            $id = $order->id;
                            $prices = OrderProduct::where('sales_channele_order', $id)->pluck('price')->all();
                            $amounts = OrderProduct::where('sales_channele_order', $id)->pluck('amount')->all();
                            foreach ($prices as $price) {
                                foreach ($amounts as $amount) {
                                    $total = $amount * $price;
                                }
                            }
                            $total_earnings += $total;
                        }
                        array_push($total_per_months, $total_earnings);
                        $yValues = $total_per_months;
                        $xValues = $dates;
                    }
                    break;
                }
            default:
                break;
        }

        //For all users or for specific user
        // //All Orders
        // $all_orders = $this->ordersWithState($request, 'all', $date, $country, $city, $type_users);
        // //New Orders
        // $new_orders = $this->ordersWithState($request, 0, $date, $country, $city, $type_users);
        // //Confirmed  Orders
        // $confirmed_orders = $this->ordersWithState($request, 4, $date, $country, $city, $type_users);
        // //Delivered  Orders
        // $delivered_orders = $this->ordersWithState($request, 10, $date, $country, $city, $type_users);
        // //Percentage

        if (count($all_orders) > 0) {
            $confirmed_percentage = count($confirmed_orders) / count($all_orders) * 100;
            if ($confirmed_percentage > 100) {
                $confirmed_percentage = 100;
            }
        } else {
            $confirmed_percentage = 0;
        }
        if (count($all_orders) > 0) {
            $delivered_percentage = count($delivered_orders) / count($all_orders) * 100;
            if ($delivered_percentage > 100) {
                $delivered_percentage = 100;
            }
        } else {
            $delivered_percentage = 0;
        }
        // $total_earnings = 0;
        // foreach ($delivered_orders as $order) {
        //     $id = $order['id'];
        //     $prices = OrderProduct::where('sales_channele_order', $id)->pluck('price')->all();
        //     $amounts = OrderProduct::where('sales_channele_order', $id)->pluck('amount')->all();
        //     foreach ($prices as $price) {
        //         foreach ($amounts as $amount) {
        //             $total = $amount * $price;
        //             $total_earnings += $total;
        //         }
        //     }
        // }
        $countries =  Country::where('id', Auth::guard('supporter')->user()->country_id)->get();
        $cities =  City::get();


        $res = [
            'new_orders' => count($new_orders),
            'confirmed_orders' => count($confirmed_orders),
            'delivered_orders' => count($delivered_orders),
            'no_answer_orders' => count($no_answer_orders),
            'not_confirmed_orders' => count($not_confirmed_orders),
            'canceled_orders' => count($canceled_orders),
            'confirmed_percentage' =>  $confirmed_percentage,
            'delivered_percentage' =>  $delivered_percentage,
            'all_orders' => count($all_orders),
            'total_earnings' => $total_earnings,
            'date' => $date_input,
            'country' => $country,
            'yValues' => $yValues,
            'xValues' => $xValues,
            'date_from' => $request->from,
            'date_to' => $request->to,
            'graph_earnings' => [], //$graph_earnings,
            'countries' => $countries,
            'cities' => $cities,
            'current_country' => $current_country,
        ];

        return view('supporter.home', compact('res', 'records', 'today_work'));
    }
}
