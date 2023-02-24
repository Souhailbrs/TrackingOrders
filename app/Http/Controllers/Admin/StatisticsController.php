<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\OrderProduct;
use App\Models\SalesChannels;
use App\Models\Seller;
use App\WorkDayOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    //States
    //=> All
    //=> From , to
    //=> Today
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

        //get values of all orders
        $current_year = Carbon::now()->format('Y');
        $current_month = Carbon::now()->format('M');
        $seller_mail = Seller::where('id', $type_users)->pluck('email')->all();
        $sales_all = SalesChannels::where('owner_email', $seller_mail)->pluck('id')->all();
        $yValues = [];
        $xValues = [];
        $months = [];
        $total_per_months = [];
        $total_earnings = 0;
        switch ($date_input) {
            case 'today': {
                    $all_orders  = Order::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->where('country_id', $country)->get();
                    $new_orders = Order::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->where('status', 0)->where('country_id', $country)->get();
                    $confirmed_orders = Order::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->where('status', 4)->get();
                    $delivered_orders = Order::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->where('status', 10)->get();
                    break;
                }
            case 'yesterday': {
                    $all_orders  = Order::whereDate('created_at', '=', Carbon::yesterday()->format('Y-m-d'))->where('country_id', $country)->get();
                    $new_orders = Order::whereDate('created_at', '=', Carbon::yesterday()->format('Y-m-d'))->where('country_id', $country)->where('status', 0)->get();
                    $confirmed_orders = Order::whereDate('created_at', '=', Carbon::yesterday()->format('Y-m-d'))->where('country_id', $country)->where('status', 4)->get();
                    $delivered_orders = Order::whereDate('created_at', '=', Carbon::yesterday()->format('Y-m-d'))->where('country_id', $country)->where('status', 10)->get();
                    break;
                }
            case '7days': {
                    $filter_date = Carbon::now()->subDays(7);
                    $all_orders  = Order::whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('country_id', $country)->get();
                    $new_orders = Order::whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('country_id', $country)->where('status', 0)->get();
                    $confirmed_orders = Order::whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('country_id', $country)->where('status', 4)->get();
                    $delivered_orders = Order::whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('country_id', $country)->where('status', 10)->get();
                    $days = array();
                    array_push($days, date('l', strtotime($filter_date)));
                    $total_per_days = [];
                    for ($i = 0; $i < 7; $i++) {
                        $total_earnings = 0;
                        $delivered_orders_per_month = Order::whereYear('created_at', '=', $current_year)
                            ->whereMonth('created_at', '=', date('m', strtotime($filter_date)))
                            ->whereDay('created_at', '=', date('d', strtotime($filter_date)))
                            ->where('country_id', $country)->where('status', 10)->get();
                        foreach ($delivered_orders_per_month as $order) {
                            $id = $order->id;
                            $price = OrderProduct::where('sales_channele_order', $id)->pluck('price')->all();
                            $amount = OrderProduct::where('sales_channele_order', $id)->pluck('amount')->all();
                            $total = $amount[0] * $price[0];
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
                    $all_orders  = Order::where('country_id', $country)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->get();
                    $new_orders = Order::where('country_id', $country)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('status', 0)->get();
                    $confirmed_orders = Order::where('country_id', $country)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('status', 4)->get();
                    $delivered_orders = Order::where('country_id', $country)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('status', 10)->get();
                    $days = array();
                    array_push($days, date('d-m-Y', strtotime($filter_date)));
                    $total_per_days = [];
                    for ($i = 0; $i < 30; $i++) {
                        $total_earnings = 0;
                        $delivered_orders_per_month = Order::whereYear('created_at', '=', $current_year)
                            ->whereMonth('created_at', '=', date('m', strtotime($filter_date)))
                            ->whereDay('created_at', '=', date('d', strtotime($filter_date)))
                            ->where('country_id', $country)->where('status', 10)->get();
                        foreach ($delivered_orders_per_month as $order) {
                            $id = $order->id;
                            $price = OrderProduct::where('sales_channele_order', $id)->pluck('price')->all();
                            $amount = OrderProduct::where('sales_channele_order', $id)->pluck('amount')->all();
                            $total = $amount[0] * $price[0];
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
                    $all_orders  = Order::whereYear('created_at', '=', $current_year)
                        ->where('country_id', $country)->get();
                    $new_orders = Order::whereYear('created_at', '=', $current_year)
                        ->where('country_id', $country)->where('status', 0)->get();
                    $confirmed_orders = Order::whereYear('created_at', '=', $current_year)
                        ->where('country_id', $country)->where('status', 4)->get();
                    $delivered_orders = Order::whereYear('created_at', '=', $current_year)
                        ->where('country_id', $country)->where('status', 10)->get();
                    $monthsname = [];
                    $total_per_months = [];
                    $total_earnings = 0;
                    for ($i = 1; $i < 13; $i++) {
                        $total_earnings = 0;
                        array_push($monthsname, date('F', strtotime('01.' . $i . '.' . $current_year)));
                        $delivered_orders_per_month = Order::whereYear('created_at', '=', $current_year)
                            ->whereMonth('created_at', '=', $i)->where('country_id', $country)->where('status', 10)->get();
                        foreach ($delivered_orders_per_month as $order) {
                            $id = $order->id;
                            $price = OrderProduct::where('sales_channele_order', $id)->pluck('price')->all();
                            $amount = OrderProduct::where('sales_channele_order', $id)->pluck('amount')->all();
                            $total = $amount[0] * $price[0];
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
                    $all_orders  = Order::whereBetween('created_at', [$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])->where('country_id', $country)->get();
                    $new_orders = Order::whereBetween('created_at', [$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])->where('country_id', $country)->where('status', 0)->get();
                    $confirmed_orders = Order::whereBetween('created_at', [$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])->where('country_id', $country)->where('status', 4)->get();
                    $delivered_orders = Order::whereBetween('created_at', [$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])->where('country_id', $country)->where('status', 10)->get();
                    $dates = [];
                    $total_per_months = [];
                    $total_earnings = 0;
                    $dates = $this->date_range1($dateS, $dateE, "+1 day", "d.m.Y");
                    foreach ($dates as $date) {
                        $total_earnings = 0;

                        $delivered_orders_per_month = Order::whereYear('created_at', '=', date('Y', strtotime($date)))
                            ->whereMonth('created_at', '=', date('m', strtotime($date)))
                            ->whereDay('created_at', '=', date('d', strtotime($date)))
                            ->where('country_id', $country)->where('status', 10)->get();

                        foreach ($delivered_orders_per_month as $order) {
                            $id = $order->id;
                            $price = OrderProduct::where('sales_channele_order', $id)->pluck('price')->all();
                            $amount = OrderProduct::where('sales_channele_order', $id)->pluck('amount')->all();
                            $total = $amount[0] * $price[0];
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


        if (count($new_orders) > 0) {
            $confirmed_percentage = count($confirmed_orders) / count($new_orders) * 100;
            if ($confirmed_percentage > 100) {
                $confirmed_percentage = 100;
            }
        } else {
            $confirmed_percentage = 0;
        }
        if (count($confirmed_orders) > 0) {
            $delivered_percentage = count($delivered_orders) / count($confirmed_orders) * 100;
            if ($delivered_percentage > 100) {
                $delivered_percentage = 100;
            }
        } else {
            $delivered_percentage = 0;
        }
        $total_earnings = 0;
        foreach ($delivered_orders as $order) {
            $id = $order->id;
            $price = OrderProduct::where('sales_channele_order', $id)->pluck('price')->all();
            $amount = OrderProduct::where('sales_channele_order', $id)->pluck('amount')->all();
            if (empty($amount) || empty($amount)) {
                $total = 0;
            } else {
                $total = $amount[0] * $price[0];
            }
            $total_earnings += $total;
        }

        // //Total Earnings
        // $total_earnings_data = $this->earningGraph($request, 10, $date, $country, $city, $type_users);
        // $total_earnings = 0;

        // foreach ($total_earnings_data  as $total) {
        //     $total_earnings_products = $total->order->product;
        //     foreach ($total_earnings_products as $pro) {
        //         $total_earnings += $pro->price;
        //     }
        // }
        // $graph_earnings =  $this->earningGraph($request, 10, $date, $country, $city, $type_users);
        $countries =  Country::get();
        $cities =  City::get();


        $res = [
            'new_orders' => count($new_orders),
            'confirmed_orders' => count($confirmed_orders),
            'delivered_orders' => count($delivered_orders),
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
            'cities' => $cities
        ];

        return view('admin.home', compact('res'));
    }
    // public function index(Request $request, $type_users)
    // {
    //     //Date that can be
    //     //All Days
    //     //Today
    //     //From to
    //     if (!$request->date) {
    //         $date = 'today';
    //     } else {
    //         $date = $request->date;
    //     }
    //     if (!$request->country) {
    //         $country = '!';
    //     } else {
    //         $country = $request->country;
    //     }
    //     if (!$request->city) {
    //         $city = '!';
    //     } else {
    //         $city = $request->city;
    //     }

    //     //For all users or for specific user

    //     //New Orders
    //     $new_orders = $this->ordersWithState($request, 0, $date, $country, $city, $type_users);
    //     //Confirmed  Orders
    //     $confirmed_orders = $this->ordersWithState($request, 4, $date, $country, $city, $type_users);
    //     //Delivered  Orders
    //     $delivered_orders = $this->ordersWithState($request, 10, $date, $country, $city, $type_users);
    //     $cancelled_orders_call_center = $this->ordersWithState($request, 6, $date, $country, $city, $type_users);
    //     $cancelled_orders_delivery = $this->ordersWithState($request, 11, $date, $country, $city, $type_users);

    //     //Percentage
    //     //All Orders
    //     $all_orders = $this->ordersWithState($request, 'all', $date, $country, $city, $type_users);

    //     if (count($new_orders) > 0) {
    //         $confirmed_percentage = count($confirmed_orders) / count($new_orders) * 100;
    //         if ($confirmed_percentage > 100) {
    //             $confirmed_percentage = 100;
    //         }
    //     } else {
    //         $confirmed_percentage = 0;
    //     }
    //     if (count($confirmed_orders) > 0) {
    //         $delivered_percentage = count($delivered_orders) / count($confirmed_orders) * 100;
    //         if ($delivered_percentage > 100) {
    //             $delivered_percentage = 100;
    //         }
    //     } else {
    //         $delivered_percentage = 0;
    //     }
    //     $cancelled_orders = count($cancelled_orders_call_center) + count($cancelled_orders_delivery);
    //     if ($cancelled_orders > 0) {
    //         $cancelled_percentage = $cancelled_orders / count($new_orders) * 100;
    //         if($cancelled_percentage > 100) {
    //             $cancelled_percentage = 100;
    //         }
    //     } else {
    //         $cancelled_percentage = 0;
    //     }

    //     //Total Earnings
    //     $total_earnings_data = $this->ordersWithState($request, 10, $date, $country, $city, $type_users);
    //     $total_earnings = 0;
    //     foreach ($total_earnings_data as $total) {
    //         $total_earnings_products = $total->order->product;
    //         foreach ($total_earnings_products as $pro) {
    //             $total_earnings += $pro->price;
    //         }
    //     }
    //     $graph_earnings = $this->earningGraph($request, 10, $date, $country, $city, $type_users);
    //     $countries = Country::get();
    //     $cities = City::get();
    //     $res = [
    //         'new_orders' => count($new_orders),
    //         'confirmed_orders' => count($confirmed_orders),
    //         'delivered_orders' => count($delivered_orders),
    //         'cancelled_orders' => count($cancelled_orders_call_center) + count($cancelled_orders_delivery),
    //         'cancelled_orders_call_center' => count($cancelled_orders_call_center),
    //         'cancelled_orders_delivery' => count($cancelled_orders_delivery),
    //         'confirmed_percentage' => $confirmed_percentage,
    //         'delivered_percentage' => $delivered_percentage,
    //         'cancelled_percentage' => $cancelled_percentage,
    //         'all_orders' => count($all_orders),
    //         'total_earnings' => $total_earnings,
    //         'graph_earnings' => $graph_earnings,
    //         'countries' => $countries,
    //         'cities' => $cities
    //     ];


    //     return view('admin.home', compact('res'));
    // }
    // public function indexFilter(Request $request, $type_users)
    // {
    //     //Date that can be
    //     //All Days
    //     //Today
    //     //From to
    //     if (!$request->date) {
    //         $date = 'today';
    //     } else {
    //         $date = $request->date;
    //     }
    //     if (!$request->country) {
    //         $country = '!';
    //     } else {
    //         $country = $request->country;
    //     }
    //     if (!$request->city) {
    //         $city = '!';
    //     } else {
    //         $city = $request->city;
    //     }

    //     //For all users or for specific user

    //     //New Orders
    //     $new_orders = $this->ordersWithState($request, 0, $date, $country, $city, $type_users);
    //     //Confirmed  Orders
    //     $confirmed_orders = $this->ordersWithState($request, 4, $date, $country, $city, $type_users);
    //     //Delivered  Orders
    //     $delivered_orders = $this->ordersWithState($request, 10, $date, $country, $city, $type_users);
    //     $cancelled_orders_call_center = $this->ordersWithState($request, 6, $date, $country, $city, $type_users);
    //     $cancelled_orders_delivery = $this->ordersWithState($request, 11, $date, $country, $city, $type_users);

    //     //Percentage
    //     //All Orders
    //     $all_orders = $this->ordersWithState($request, 'all', $date, $country, $city, $type_users);

    //     if (count($new_orders) > 0) {
    //         $confirmed_percentage = count($confirmed_orders) / count($new_orders) * 100;
    //         if ($confirmed_percentage > 100) {
    //             $confirmed_percentage = 100;
    //         }
    //     } else {
    //         $confirmed_percentage = 0;
    //     }
    //     if (count($confirmed_orders) > 0) {
    //         $delivered_percentage = count($delivered_orders) / count($confirmed_orders) * 100;
    //         if ($delivered_percentage > 100) {
    //             $delivered_percentage = 100;
    //         }
    //     } else {
    //         $delivered_percentage = 0;
    //     }
    //     $cancelled_orders = count($cancelled_orders_call_center) + count($cancelled_orders_delivery);
    //     if ($cancelled_orders > 0) {
    //         $cancelled_percentage = $cancelled_orders / count($new_orders) * 100;
    //         if($cancelled_percentage > 100) {
    //             $cancelled_percentage = 100;
    //         }
    //     } else {
    //         $cancelled_percentage = 0;
    //     }

    //     //Total Earnings
    //     $total_earnings_data = $this->ordersWithState($request, 10, $date, $country, $city, $type_users);
    //     $total_earnings = 0;
    //     foreach ($total_earnings_data as $total) {
    //         $total_earnings_products = $total->order->product;
    //         foreach ($total_earnings_products as $pro) {
    //             $total_earnings += $pro->price;
    //         }
    //     }
    //     $graph_earnings = $this->earningGraph($request, 10, $date, $country, $city, $type_users);
    //     $countries = Country::get();
    //     $cities = City::get();
    //     $res = [
    //         'new_orders' => count($new_orders),
    //         'confirmed_orders' => count($confirmed_orders),
    //         'delivered_orders' => count($delivered_orders),
    //         'cancelled_orders' => count($cancelled_orders_call_center) + count($cancelled_orders_delivery),
    //         'cancelled_orders_call_center' => count($cancelled_orders_call_center),
    //         'cancelled_orders_delivery' => count($cancelled_orders_delivery),
    //         'confirmed_percentage' => $confirmed_percentage,
    //         'delivered_percentage' => $delivered_percentage,
    //         'cancelled_percentage' => $cancelled_percentage,
    //         'all_orders' => count($all_orders),
    //         'total_earnings' => $total_earnings,
    //         'graph_earnings' => $graph_earnings,
    //         'countries' => $countries,
    //         'cities' => $cities
    //     ];

    //     return $res;
    // }

    // //Abstract Orders
    // public function ordersWithState(Request $request, $status, $state, $country, $city, $type_users)
    // {
    //     $filtered_orders = [];
    //     $filtered_orders2 = [];
    //     $filtered_orders3 = [];
    //     if ($status != 'all') {
    //         $orders = OrderLog::where('status', $status)->get();
    //     } else {
    //         $orders = OrderLog::get();
    //     }
    //     if ($type_users != 'all') {
    //         $orders = $this->SellerOrders($orders, $type_users);
    //     }

    //     if ($request->country) {
    //         foreach ($orders as $order) {
    //             if ($country != '!') {
    //                 if ($order->order->country_id == $country) {
    //                     $filtered_orders2 [] = $order;
    //                 }
    //             } else {
    //                 $filtered_orders2 [] = $order;
    //             }
    //         }
    //     } else {
    //         foreach ($orders as $order) {
    //             $filtered_orders2 [] = $order;

    //         }
    //     }

    //     return $this->dateFilter($request, $filtered_orders2, $state);
    // }

    // public function SellerOrders($orders, $type_user)
    // {
    //     $filtered_orders = [];
    //     $seller = Seller::find($type_user);
    //     $sales_channels = SalesChannels::where('owner_email', $seller->email)->get();
    //     $ids = [];
    //     foreach ($sales_channels as $sale) {
    //         $ids [] = $sale->id;
    //     }
    //     foreach ($orders as $order) {
    //         if (in_array($order->sales_channel, $ids)) {
    //             $filtered_orders [] = $order;
    //         }
    //     }

    //     return $filtered_orders;
    // }

    // public function dateFilter(Request $request, $array, $state)
    // {
    //     $result = [];
    //     foreach ($array as $arr) {
    //         switch ($state) {
    //             case 'all':
    //                 $result[] = $arr;
    //                 break;
    //             case 'from':
    //                 $order_date_from = date('Y-m-d', strtotime($request->from));
    //                 $order_date_to = date('Y-m-d', strtotime($request->to));
    //                 $order_date = date('Y-m-d', strtotime($arr->created_at));
    //                 if ($order_date >= $order_date_from && $order_date <= $order_date_to) {
    //                     $result[] = $arr;
    //                 }
    //                 break;
    //             case 'today':
    //                 $order_date_today = date('Y-m-d', strtotime($arr->created_at));
    //                 $today = date('Y-m-d', strtotime(date('Y-m-d')));
    //                 if ($order_date_today === $today) {
    //                     $result[] = $arr;
    //                 }
    //                 break;
    //         }
    //     }
    //     return $result;
    // }

    // public function earningGraph(Request $request, $status, $state, $country, $city, $type_users)
    // {
    //     //We have 3 cases
    //     //1. From start till now
    //     //2. All Days.
    //     //3. From to date.
    //     $filtered_orders = [];
    //     $filtered_orders2 = [];
    //     $filtered_orders3 = [];
    //     $result = [];

    //     if ($status != 'all') {
    //         $orders = OrderLog::where('status', $status)->get();
    //     } else {
    //         $orders = OrderLog::get();
    //     }
    //     if ($type_users != 'all') {
    //         $orders = $this->SellerOrders($orders, $type_users);
    //     }

    //     foreach ($orders as $order) {
    //         if ($country != '!') {
    //             if ($order->order->country_id == $country) {
    //                 $filtered_orders2 [] = $order;
    //             }
    //         } else {
    //             $filtered_orders2 [] = $order;
    //         }
    //     }
    //     $order_log = $this->dateFilter($request, $filtered_orders2, $state);
    //     $real_orders = [];
    //     foreach ($order_log as $orlog) {
    //         $real_orders [] = $orlog->order;
    //     }
    //     //Get unique dats
    //     $days = [];
    //     foreach ($real_orders as $dayUnique) {
    //         $days [] = date('Y-m-d', strtotime($dayUnique->created_at));
    //     }
    //     $days = array_unique($days);


    //     foreach ($days as $day) {
    //         foreach ($orders as $order) {
    //             $order_day = date('Y-m-d', strtotime($order->created_at));
    //             if ($order_day == $day) {
    //                 $result[$day] [] = $order;
    //             }
    //         }
    //     }

    //     foreach ($result as $key => $value) {
    //         $orders = $value;
    //         $price = 0;
    //         foreach ($orders as $order) {
    //             $products = $order->order->product;
    //             foreach ($products as $pro) {
    //                 $price += $pro->price;
    //             }
    //         }
    //         $result[$key] = $price;
    //     }

    //     return $result;

    // }

    //Earnings

    public function getSellerWithOrder($order)
    {
        return Seller::where('email', $order->shop->owner_email)->first()->id;
    }

    // public function earningGraphOld(Request $request, $filter)
    // {
    //     //We have 3 cases
    //     //1. From start till now
    //     //2. All Days.
    //     //3. From to date.
    //     $orders = Order::select('id', 'status', 'created_at')->where('status', 10)->get();
    //     $result = [];
    //     $days = [];
    //     $today = date('Y-m-d', strtotime(date('Y-m-d')));
    //     if ($filter == 'today') {
    //         foreach ($orders as $order) {
    //             $order_date = date('Y-m-d', strtotime($order->created_at));
    //             if ($order_date == $today) {
    //                 $days [] = $order_date;
    //             }
    //         }
    //     } elseif ($filter == 'all') {
    //         foreach ($orders as $order) {
    //             $order_date = date('Y-m-d', strtotime($order->created_at));
    //             $days [] = $order_date;
    //         }

    //     } elseif ($filter == 'from') {
    //         $from = date('Y-m-d', strtotime($request->from));
    //         $to = date('Y-m-d', strtotime($request->to));
    //         foreach ($orders as $order) {
    //             $order_date = date('Y-m-d', strtotime($order->created_at));
    //             if ($order_date >= $from && $order_date <= $to) {
    //                 $days [] = $order_date;
    //             }
    //         }
    //     }

    //     $days = array_unique($days);
    //     foreach ($days as $day) {
    //         foreach ($orders as $order) {
    //             $order_day = date('Y-m-d', strtotime($order->created_at));
    //             if ($order_day == $day) {
    //                 $result[$day] [] = $order;
    //             }
    //         }
    //     }

    //     foreach ($result as $key => $value) {
    //         $orders = $value;
    //         $price = 0;
    //         foreach ($orders as $order) {
    //             $products = $order->product;
    //             foreach ($products as $pro) {
    //                 $price += $pro->price;
    //             }
    //         }
    //         $result[$key] = $price;
    //     }

    //     return $result;

    // }


}
