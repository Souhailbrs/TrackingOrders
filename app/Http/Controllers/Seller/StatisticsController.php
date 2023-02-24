<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\OrderProduct;
use App\Models\ProductSeller;
use App\Models\SalesChannels;
use App\Models\Seller;
use App\WorkDayOrder;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
        if (!$request->product) {
            $selected_product = 'all';
        } else {
            $selected_product = $request->product;
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
        $all_products = ProductSeller::where('seller_id', Auth::guard('seller')->user()->id)->get();
        if ($selected_product == 'all') {
            $products = $all_products;
        } else {
            $products = ProductSeller::where('id', $selected_product)->get();
        }
        $shop_ids = [];
        foreach ($products as $product) {
            $shop_ids[] = $product->shop_id;
        };
        //get values of all orders
        $current_country = Country::where('id', $country)->pluck('currency_symbol')->all();

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
                    if ($selected_product == 'all') {
                        $all_orders  = Order::where('sales_channel', $sales_all)->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->where('country_id', $country)->get();
                        $new_orders = Order::where('sales_channel', $sales_all)->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->where('status', 0)->where('country_id', $country)->get();
                        $confirmed_orders = Order::where('sales_channel', $sales_all)->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->where('status', 4)->get();
                        $delivered_orders = Order::where('sales_channel', $sales_all)->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->where('status', 10)->get();
                        $canceled_orders = Order::where('sales_channel', $sales_all)->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->whereIn('status', [2, 3, 5, 6, 9, 11, 12, 13])->get();
                    } else {
                        $all_orders_shop  = Order::whereIn('sales_channel', $shop_ids)->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->where('country_id', $country)->pluck('id')->all();
                        $confirmed_orders_shop = Order::whereIn('sales_channel', $shop_ids)->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->where('status', 4)->pluck('id')->all();
                        $delivered_orders_shop = Order::whereIn('sales_channel', $shop_ids)->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->where('status', 10)->pluck('id')->all();
                        $canceled_orders_shop = Order::whereIn('sales_channel', $shop_ids)->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->whereIn('status', [2, 3, 5, 6, 9, 11, 12, 13])->pluck('id')->all();

                        $all_orders = OrderProduct::whereIn('sales_channele_order', $all_orders_shop)->where('product_id', $selected_product)->get();
                        $confirmed_orders = OrderProduct::whereIn('sales_channele_order', $confirmed_orders_shop)->where('product_id', $selected_product)->get();
                        $delivered_orders = OrderProduct::whereIn('sales_channele_order', $delivered_orders_shop)->where('product_id', $selected_product)->get();
                        $canceled_orders = OrderProduct::whereIn('sales_channele_order', $canceled_orders_shop)->where('product_id', $selected_product)->get();
                    }
                    break;
                }
            case 'yesterday': {
                    if ($selected_product == 'all') {
                        $all_orders  = Order::where('sales_channel', $sales_all)->whereDate('created_at', '=', Carbon::yesterday()->format('Y-m-d'))->where('country_id', $country)->get();
                        $confirmed_orders = Order::where('sales_channel', $sales_all)->whereDate('created_at', '=', Carbon::yesterday()->format('Y-m-d'))->where('country_id', $country)->where('status', 4)->get();
                        $delivered_orders = Order::where('sales_channel', $sales_all)->whereDate('created_at', '=', Carbon::yesterday()->format('Y-m-d'))->where('country_id', $country)->where('status', 10)->get();
                        $canceled_orders = Order::where('sales_channel', $sales_all)->whereDate('created_at', '=', Carbon::yesterday()->format('Y-m-d'))->where('country_id', $country)->where('status', [2, 3, 5, 6, 9, 11, 12, 13])->get();
                    } else {
                        $all_orders_shop  = Order::whereIn('sales_channel', $shop_ids)->whereDate('created_at', '=', Carbon::yesterday()->format('Y-m-d'))->where('country_id', $country)->pluck('id')->all();
                        $confirmed_orders_shop = Order::whereIn('sales_channel', $shop_ids)->whereDate('created_at', '=', Carbon::yesterday()->format('Y-m-d'))->where('country_id', $country)->where('status', 4)->pluck('id')->all();
                        $delivered_orders_shop = Order::whereIn('sales_channel', $shop_ids)->whereDate('created_at', '=', Carbon::yesterday()->format('Y-m-d'))->where('country_id', $country)->where('status', 10)->pluck('id')->all();
                        $canceled_orders_shop = Order::whereIn('sales_channel', $shop_ids)->whereDate('created_at', '=', Carbon::yesterday()->format('Y-m-d'))->where('country_id', $country)->where('status', [2, 3, 5, 6, 9, 11, 12, 13])->pluck('id')->all();

                        $all_orders = OrderProduct::whereIn('sales_channele_order', $all_orders_shop)->where('product_id', $selected_product)->get();
                        $confirmed_orders = OrderProduct::whereIn('sales_channele_order', $confirmed_orders_shop)->where('product_id', $selected_product)->get();
                        $delivered_orders = OrderProduct::whereIn('sales_channele_order', $delivered_orders_shop)->where('product_id', $selected_product)->get();
                        $canceled_orders = OrderProduct::whereIn('sales_channele_order', $canceled_orders_shop)->where('product_id', $selected_product)->get();
                    }

                    break;
                }
            case '7days': {
                    $filter_date = Carbon::now()->subDays(8);
                    if ($selected_product == 'all') {
                        $all_orders  = Order::where('sales_channel', $sales_all)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('country_id', $country)->get();
                        $confirmed_orders = Order::where('sales_channel', $sales_all)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('country_id', $country)->where('status', 4)->get();
                        $delivered_orders = Order::where('sales_channel', $sales_all)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('country_id', $country)->where('status', 10)->get();
                        $canceled_orders = Order::where('sales_channel', $sales_all)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('country_id', $country)->where('status', [2, 3, 5, 6, 9, 11, 12, 13])->get();
                        $days = array();
                        $filter_date = date('d.m.Y', strtotime($filter_date . ' + 1 days'));
                        array_push($days, date('l', strtotime($filter_date)));
                        $total_per_days = [];
                        for ($i = 0; $i < 8; $i++) {
                            $total_earnings = 0;
                            $delivered_orders_per_month = Order::where('sales_channel', $sales_all)
                                ->whereYear('created_at', '=', $current_year)
                                ->whereMonth('created_at', '=', date('m', strtotime($filter_date)))
                                ->whereDay('created_at', '=', date('d', strtotime($filter_date)))
                                ->where('country_id', $country)->where('status', 10)->get();
                            if ($i == 7) {
                                $delivered_orders_per_month = Order::where('sales_channel', $sales_all)
                                    ->whereDate('created_at', '=', Carbon::today()->format('Y-m-d'))
                                    ->where('country_id', $country)->where('status', 10)->get();
                            }
                            foreach ($delivered_orders_per_month as $orderd) {
                                $id = $orderd->id;
                                $orderCalcu = OrderProduct::where('sales_channele_order', $id)->get();
                                foreach ($orderCalcu as $order) {
                                    $price = $order->price;
                                    $amount = $order->amount;
                                    $total = $amount * $price;
                                    $total_earnings += $total;
                                }
                            }
                            array_push($total_per_days, $total_earnings);
                            $filter_date = date('d.m.Y', strtotime($filter_date . ' + 1 days'));
                            array_push($days, date('l', strtotime($filter_date)));
                        }
                        $yValues = $total_per_days;
                        $xValues = $days;
                    } else {
                        $all_orders_shop  = Order::whereIn('sales_channel', $shop_ids)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('country_id', $country)->pluck('id')->all();
                        $confirmed_orders_shop = Order::whereIn('sales_channel', $shop_ids)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('country_id', $country)->where('status', 4)->pluck('id')->all();
                        $delivered_orders_shop = Order::whereIn('sales_channel', $shop_ids)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('country_id', $country)->where('status', 10)->pluck('id')->all();
                        $canceled_orders_shop = Order::whereIn('sales_channel', $shop_ids)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('country_id', $country)->where('status', [2, 3, 5, 6, 9, 11, 12, 13])->pluck('id')->all();

                        $all_orders = OrderProduct::whereIn('sales_channele_order', $all_orders_shop)->where('product_id', $selected_product)->get();
                        $confirmed_orders = OrderProduct::whereIn('sales_channele_order', $confirmed_orders_shop)->where('product_id', $selected_product)->get();
                        $delivered_orders = OrderProduct::whereIn('sales_channele_order', $delivered_orders_shop)->where('product_id', $selected_product)->get();
                        $canceled_orders = OrderProduct::whereIn('sales_channele_order', $canceled_orders_shop)->where('product_id', $selected_product)->get();
                        $days = array();
                        $filter_date = date('d.m.Y', strtotime($filter_date . ' + 1 days'));
                        array_push($days, date('l', strtotime($filter_date)));
                        $total_per_days = [];
                        for ($i = 0; $i < 8; $i++) {
                            $total_earnings = 0;
                            $delivered_orders_per_month_shop = Order::whereYear('created_at', '=', $current_year)
                                ->whereMonth('created_at', '=', date('m', strtotime($filter_date)))
                                ->whereDay('created_at', '=', date('d', strtotime($filter_date)))
                                ->whereIn('sales_channel', $shop_ids)->where('country_id', $country)
                                ->where('status', 10)->pluck('id')->all();
                            $delivered_orders_per_month = OrderProduct::whereIn('sales_channele_order', $delivered_orders_per_month_shop)
                                ->where('product_id', $selected_product)->get();
                            if ($i == 7) {
                                $delivered_orders_per_month_shop = Order::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))
                                    ->whereIn('sales_channel', $shop_ids)->where('country_id', $country)
                                    ->where('status', 10)->pluck('id')->all();
                                $delivered_orders_per_month = OrderProduct::whereIn('sales_channele_order', $delivered_orders_per_month_shop)
                                    ->where('product_id', $selected_product)->get();
                            }
                            foreach ($delivered_orders_per_month  as $order) {
                                $price = $order->price;
                                $amount = $order->amount;
                                $total = $amount * $price;
                                $total_earnings += $total;
                            }
                            array_push($total_per_days, $total_earnings);
                            $filter_date = date('d.m.Y', strtotime($filter_date . ' + 1 days'));
                            array_push($days, date('l', strtotime($filter_date)));
                        }
                        $yValues = $total_per_days;
                        $xValues = $days;
                    }


                    break;
                }
            case '30days': {
                    $filter_date = Carbon::now()->subDays(31);
                    if ($selected_product == 'all') {
                        $all_orders  = Order::where('sales_channel', $sales_all)->where('country_id', $country)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->get();
                        $new_orders = Order::where('sales_channel', $sales_all)->where('country_id', $country)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('status', 0)->get();
                        $confirmed_orders = Order::where('sales_channel', $sales_all)->where('country_id', $country)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('status', 4)->get();
                        $delivered_orders = Order::where('sales_channel', $sales_all)->where('country_id', $country)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('status', 10)->get();
                        $canceled_orders = Order::where('sales_channel', $sales_all)->where('country_id', $country)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('status', [2, 3, 5, 6, 9, 11, 12, 13])->get();
                        $days = array();
                        $filter_date = date('d.m.Y', strtotime($filter_date . ' + 1 days'));
                        array_push($days, date('d-m-Y', strtotime($filter_date)));
                        $total_per_days = [];
                        for ($i = 0; $i < 31; $i++) {
                            $total_earnings = 0;
                            $delivered_orders_per_month = Order::where('sales_channel', $sales_all)
                                ->whereYear('created_at', '=', $current_year)
                                ->whereMonth('created_at', '=', date('m', strtotime($filter_date)))
                                ->whereDay('created_at', '=', date('d', strtotime($filter_date)))
                                ->where('country_id', $country)->where('status', 10)->get();
                            if ($i == 30) {
                                $delivered_orders_per_month = Order::where('sales_channel', $sales_all)
                                    ->whereDate('created_at', '=', Carbon::today()->format('Y-m-d'))
                                    ->where('country_id', $country)->where('status', 10)->get();
                            }
                            foreach ($delivered_orders_per_month as $orderd) {
                                $id = $orderd->id;
                                $orderCalcu = OrderProduct::where('sales_channele_order', $id)->get();
                                foreach ($orderCalcu as $order) {
                                    $price = $order->price;
                                    $amount = $order->amount;
                                    $total = $amount * $price;
                                    $total_earnings += $total;
                                }
                            }
                            array_push($total_per_days, $total_earnings);
                            $filter_date = date('d.m.Y', strtotime($filter_date . ' + 1 days'));
                            array_push($days, date('l', strtotime($filter_date)) . ' - ' . date('d-m-Y', strtotime($filter_date)));
                        }
                        $yValues = $total_per_days;
                        $xValues = $days;
                    } else {
                        $all_orders_shop  = Order::whereIn('sales_channel', $shop_ids)->where('country_id', $country)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->pluck('id')->all();
                        $confirmed_orders_shop = Order::whereIn('sales_channel', $shop_ids)->where('country_id', $country)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('status', 4)->pluck('id')->all();
                        $delivered_orders_shop = Order::whereIn('sales_channel', $shop_ids)->where('country_id', $country)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('status', 10)->pluck('id')->all();
                        $canceled_orders_shop = Order::whereIn('sales_channel', $shop_ids)->where('country_id', $country)->whereDate('created_at', '>=', $filter_date->format('Y-m-d'))->where('status', [2, 3, 5, 6, 9, 11, 12, 13])->pluck('id')->all();

                        $all_orders = OrderProduct::whereIn('sales_channele_order', $all_orders_shop)->where('product_id', $selected_product)->get();
                        $confirmed_orders = OrderProduct::whereIn('sales_channele_order', $confirmed_orders_shop)->where('product_id', $selected_product)->get();
                        $delivered_orders = OrderProduct::whereIn('sales_channele_order', $delivered_orders_shop)->where('product_id', $selected_product)->get();
                        $canceled_orders = OrderProduct::whereIn('sales_channele_order', $canceled_orders_shop)->where('product_id', $selected_product)->get();
                        $days = array();
                        $filter_date = date('d.m.Y', strtotime($filter_date . ' + 1 days'));
                        array_push($days, date('d-m-Y', strtotime($filter_date)));
                        $total_per_days = [];
                        for ($i = 0; $i < 31; $i++) {
                            $total_earnings = 0;
                            $delivered_orders_per_month_shop = Order::whereYear('created_at', '=', $current_year)
                                ->whereMonth('created_at', '=', date('m', strtotime($filter_date)))
                                ->whereDay('created_at', '=', date('d', strtotime($filter_date)))
                                ->whereIn('sales_channel', $shop_ids)->where('country_id', $country)
                                ->where('status', 10)->pluck('id')->all();
                            $delivered_orders_per_month = OrderProduct::whereIn('sales_channele_order', $delivered_orders_per_month_shop)
                                ->where('product_id', $selected_product)->get();
                            if ($i == 30) {
                                $delivered_orders_per_month_shop = Order::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))
                                    ->whereIn('sales_channel', $shop_ids)->where('country_id', $country)
                                    ->where('status', 10)->pluck('id')->all();
                                $delivered_orders_per_month = OrderProduct::whereIn('sales_channele_order', $delivered_orders_per_month_shop)
                                    ->where('product_id', $selected_product)->get();
                            }
                            foreach ($delivered_orders_per_month  as $order) {
                                $price = $order->price;
                                $amount = $order->amount;
                                $total = $amount * $price;
                                $total_earnings += $total;
                            }
                            array_push($total_per_days, $total_earnings);
                            $filter_date = date('d.m.Y', strtotime($filter_date . ' + 1 days'));
                            array_push($days, date('l', strtotime($filter_date)) . ' - ' . date('d-m-Y', strtotime($filter_date)));
                        }
                        $yValues = $total_per_days;
                        $xValues = $days;
                    }


                    break;
                }
            case 'all': {
                    if ($selected_product == 'all') {
                        $all_orders  = Order::whereYear('created_at', '=', $current_year)
                            ->where('sales_channel', $sales_all)->where('country_id', $country)->get();
                        $new_orders = Order::whereYear('created_at', '=', $current_year)
                            ->where('sales_channel', $sales_all)->where('country_id', $country)->where('status', 0)->get();
                        $confirmed_orders = Order::whereYear('created_at', '=', $current_year)
                            ->where('sales_channel', $sales_all)->where('country_id', $country)->where('status', 4)->get();
                        $delivered_orders = Order::whereYear('created_at', '=', $current_year)
                            ->where('sales_channel', $sales_all)->where('country_id', $country)->where('status', 10)->get();
                        $canceled_orders = Order::whereYear('created_at', '=', $current_year)
                            ->where('sales_channel', $sales_all)->where('country_id', $country)->where('status', [2, 3, 5, 6, 9, 11, 12, 13])->get();
                        $delivered_orders_shop = Order::whereYear('created_at', '=', $current_year)
                            ->where('sales_channel', $sales_all)->where('country_id', $country)->where('status', 10)->pluck('id')->all();
                        $monthsname = [];
                        $total_per_months = [];
                        $total_earnings = 0;
                        for ($i = 1; $i < 13; $i++) {
                            $total_earnings = 0;
                            array_push($monthsname, date('F', strtotime('01.' . $i . '.' . $current_year)));
                            $delivered_orders_per_month = Order::where('sales_channel', $sales_all)->whereYear('created_at', '=', $current_year)
                                ->whereMonth('created_at', '=', $i)->where('country_id', $country)->where('status', 10)->get();
                            foreach ($delivered_orders_per_month as $orderd) {
                                $id = $orderd->id;
                                $orderCalcu = OrderProduct::where('sales_channele_order', $id)->get();
                                foreach ($orderCalcu as $order) {
                                    $price = $order->price;
                                    $amount = $order->amount;
                                    $total = $amount * $price;
                                    $total_earnings += $total;
                                }
                            }
                            array_push($total_per_months, $total_earnings);
                        }
                        $yValues = $total_per_months;
                        $xValues = $monthsname;
                    } else {
                        $all_orders_shop  = Order::whereYear('created_at', '=', $current_year)
                            ->whereIn('sales_channel', $shop_ids)->where('country_id', $country)->pluck('id')->all();

                        $confirmed_orders_shop = Order::whereYear('created_at', '=', $current_year)
                            ->whereIn('sales_channel', $shop_ids)->where('country_id', $country)->where('status', 4)->pluck('id')->all();
                        $delivered_orders_shop = Order::whereYear('created_at', '=', $current_year)
                            ->whereIn('sales_channel', $shop_ids)->where('country_id', $country)->where('status', 10)->pluck('id')->all();
                        $canceled_orders_shop = Order::whereYear('created_at', '=', $current_year)
                            ->whereIn('sales_channel', $shop_ids)->where('country_id', $country)->where('status', [2, 3, 5, 6, 9, 11, 12, 13])->pluck('id')->all();
                        $all_orders = OrderProduct::whereIn('sales_channele_order', $all_orders_shop)->where('product_id', $selected_product)->get();
                        $confirmed_orders = OrderProduct::whereIn('sales_channele_order', $confirmed_orders_shop)->where('product_id', $selected_product)->get();
                        $delivered_orders = OrderProduct::whereIn('sales_channele_order', $delivered_orders_shop)->where('product_id', $selected_product)->get();
                        $canceled_orders = OrderProduct::whereIn('sales_channele_order', $canceled_orders_shop)->where('product_id', $selected_product)->get();
                        $monthsname = [];
                        $total_per_months = [];
                        $total_earnings = 0;
                        for ($i = 1; $i < 13; $i++) {
                            $total_earnings = 0;
                            array_push($monthsname, date('F', strtotime('01.' . $i . '.' . $current_year)));
                            $delivered_orders_per_month_shop = Order::whereYear('created_at', '=', $current_year)
                                ->whereMonth('created_at', '=', $i)->whereIn('sales_channel', $shop_ids)->where('country_id', $country)->where('status', 10)->pluck('id')->all();
                            $delivered_orders_per_month = OrderProduct::whereIn('sales_channele_order', $delivered_orders_per_month_shop)->where('product_id', $selected_product)->get();
                            foreach ($delivered_orders_per_month  as $order) {
                                $price = $order->price;
                                $amount = $order->amount;
                                $total = $amount * $price;
                                $total_earnings += $total;
                            }
                            array_push($total_per_months, $total_earnings);
                        }
                        $yValues = $total_per_months;
                        $xValues = $monthsname;
                    }

                    break;
                }
            case 'from': {
                    $dateS = new Carbon($request->from);
                    $dateE = new Carbon($request->to);
                    if ($selected_product=='all') {
                        $all_orders  = Order::where('sales_channel', $sales_all)->whereBetween('created_at', [$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])->where('country_id', $country)->get();
                        $confirmed_orders = Order::where('sales_channel', $sales_all)->whereBetween('created_at', [$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])->where('country_id', $country)->where('status', 4)->get();
                        $delivered_orders = Order::where('sales_channel', $sales_all)->whereBetween('created_at', [$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])->where('country_id', $country)->where('status', 10)->get();
                        $canceled_orders = Order::where('sales_channel', $sales_all)->whereBetween('created_at', [$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])->where('country_id', $country)->where('status', [2, 3, 5, 6, 9, 11, 12, 13])->get();
                        
                        $dates = [];
                        $total_per_months = [];
                        $total_earnings = 0;
                        $dates = $this->date_range1($dateS, $dateE, "+1 day", "d.m.Y");
                        foreach ($dates as $date) {
                            $total_earnings = 0;

                            $delivered_orders_per_month = Order::where('sales_channel', $sales_all)
                                ->whereYear('created_at', '=', date('Y', strtotime($date)))
                                ->whereMonth('created_at', '=', date('m', strtotime($date)))
                                ->whereDay('created_at', '=', date('d', strtotime($date)))
                                ->where('country_id', $country)->where('status', 10)->get();

                            foreach ($delivered_orders_per_month as $orderd) {
                                $id = $orderd->id;
                                $orderCalcu = OrderProduct::where('sales_channele_order', $id)->get();
                                foreach ($orderCalcu as $order) {
                                    $price = $order->price;
                                    $amount = $order->amount;
                                    $total = $amount * $price;
                                    $total_earnings += $total;
                                }
                            }
                            array_push($total_per_months, $total_earnings);
                            $yValues = $total_per_months;
                            $xValues = $dates;
                        }
                    } else {

                        $all_orders_shop  = Order::whereIn('sales_channel', $shop_ids)->whereBetween('created_at', [$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])->where('country_id', $country)->pluck('id')->all();
                        $confirmed_orders_shop = Order::whereIn('sales_channel', $shop_ids)->whereBetween('created_at', [$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])->where('country_id', $country)->where('status', 4)->pluck('id')->all();
                        $delivered_orders_shop = Order::whereIn('sales_channel', $shop_ids)->whereBetween('created_at', [$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])->where('country_id', $country)->where('status', 10)->pluck('id')->all();
                        $canceled_orders_shop = Order::whereIn('sales_channel', $shop_ids)->whereBetween('created_at', [$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])->where('country_id', $country)->where('status', [2, 3, 5, 6, 9, 11, 12, 13])->pluck('id')->all();

                        $all_orders = OrderProduct::whereIn('sales_channele_order', $all_orders_shop)->where('product_id', $selected_product)->get();
                        $confirmed_orders = OrderProduct::whereIn('sales_channele_order', $confirmed_orders_shop)->where('product_id', $selected_product)->get();
                        $delivered_orders = OrderProduct::whereIn('sales_channele_order', $delivered_orders_shop)->where('product_id', $selected_product)->get();
                        $canceled_orders = OrderProduct::whereIn('sales_channele_order', $canceled_orders_shop)->where('product_id', $selected_product)->get();
                        $dates = [];
                        $total_per_months = [];
                        $total_earnings = 0;
                        $dates = $this->date_range1($dateS, $dateE, "+1 day", "d.m.Y");
                        foreach ($dates as $date) {
                            $total_earnings = 0;
                            $delivered_orders_per_month_shop = Order::whereYear('created_at', '=', $current_year)
                            ->whereMonth('created_at', '=', date('m', strtotime($date)))
                            ->whereDay('created_at', '=', date('d', strtotime($date)))
                            ->whereIn('sales_channel', $shop_ids)->where('country_id', $country)
                                ->where('status', 10)->pluck('id')->all();
                            $delivered_orders_per_month = OrderProduct::whereIn('sales_channele_order', $delivered_orders_per_month_shop)
                                ->where('product_id', $selected_product)->get();
                            foreach ($delivered_orders_per_month  as $order) {
                                $price = $order->price;
                                $amount = $order->amount;
                                $total = $amount * $price;
                                $total_earnings += $total;
                            }
                            array_push($total_per_months, $total_earnings);
                            $yValues = $total_per_months;
                            $xValues = $dates;
                        }
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
        $total_earnings = 0;
        if ($selected_product == 'all') {
            foreach ($delivered_orders as $orderd) {
                $id = $orderd->id;
                $orderCalcu = OrderProduct::where('sales_channele_order', $id)->get();
                foreach ($orderCalcu as $order) {
                    $price = $order->price;
                    $amount = $order->amount;
                    $total = $amount * $price;
                    $total_earnings += $total;
                }
            }
        } else {
            foreach ($delivered_orders as $order) {
                $price = $order->price;
                $amount = $order->amount;
                $total = $amount * $price;
                $total_earnings += $total;
            }
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
            'confirmed_orders' => count($confirmed_orders),
            'delivered_orders' => count($delivered_orders),
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
            'current_country' => $current_country,
            'cities' => $cities,
            'products' => $all_products,
            'selected_product' => $selected_product,
        ];

        return view('seller.home', compact('res'));
    }

    //Abstract Orders
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
    //                     $filtered_orders2[] = $order;
    //                 }
    //             } else {
    //                 $filtered_orders2[] = $order;
    //             }
    //         }
    //     } else {
    //         foreach ($orders as $order) {
    //             $filtered_orders2[] = $order;
    //         }
    //     }

    //     return $this->dateFilter($request, $filtered_orders2, $state);
    // }
    // public function SellerOrders($orders, $type_user)
    // {
    //     $filtered_orders = [];
    //     $seller = Seller::find($type_user);
    //     $sales_channels  = SalesChannels::where('owner_email', $seller->email)->get();

    //     $ids = [];
    //     foreach ($sales_channels as $sale) {
    //         $ids[] = $sale->id;
    //     }

    //     foreach ($orders as $order) {
    //         if (in_array($order->order->sales_channel, $ids)) {
    //             $filtered_orders[] = $order;
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
    // public function getSellerWithOrder($order)
    // {
    //     return Seller::where('email', $order->shop->owner_email)->first()->id;
    // }
    // //Earnings
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
    //                 $filtered_orders2[] = $order;
    //             }
    //         } else {
    //             $filtered_orders2[] = $order;
    //         }
    //     }
    //     $order_log =  $this->dateFilter($request, $filtered_orders2, $state);
    //     $real_orders = [];
    //     foreach ($order_log as $orlog) {
    //         $real_orders[] = $orlog->order;
    //     }
    //     //Get unique dats
    //     $days = [];
    //     foreach ($real_orders as $dayUnique) {
    //         $days[] =  date('Y-m-d', strtotime($dayUnique->created_at));
    //     }
    //     $days = array_unique($days);


    //     foreach ($days as $day) {
    //         foreach ($orders as $order) {
    //             $order_day = date('Y-m-d', strtotime($order->created_at));
    //             if ($order_day == $day) {
    //                 $result[$day][] = $order;
    //             }
    //         }
    //     }

    //     foreach ($result as $key => $value) {
    //         $orders =  $value;
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
    //                 $days[] = $order_date;
    //             }
    //         }
    //     } elseif ($filter == 'all') {
    //         foreach ($orders as $order) {
    //             $order_date = date('Y-m-d', strtotime($order->created_at));
    //             $days[] = $order_date;
    //         }
    //     } elseif ($filter == 'from') {
    //         $from = date('Y-m-d', strtotime($request->from));
    //         $to = date('Y-m-d', strtotime($request->to));
    //         foreach ($orders as $order) {
    //             $order_date = date('Y-m-d', strtotime($order->created_at));
    //             if ($order_date >=  $from && $order_date <= $to) {
    //                 $days[] = $order_date;
    //             }
    //         }
    //     }

    //     $days = array_unique($days);
    //     foreach ($days as $day) {
    //         foreach ($orders as $order) {
    //             $order_day = date('Y-m-d', strtotime($order->created_at));
    //             if ($order_day == $day) {
    //                 $result[$day][] = $order;
    //             }
    //         }
    //     }

    //     foreach ($result as $key => $value) {
    //         $orders =  $value;
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
