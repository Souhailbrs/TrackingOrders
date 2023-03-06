<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\SalesChannels;
use App\Models\Seller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdvancedController extends Controller
{
    public function updateOrdersToBeNewToday()
    {
        $orders = Order::where('id', '>=', 1000)->get();

        foreach ($orders as $ord) {
            if ($ord->status != 10) {
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
                $ord->update([
                    'status' => 0,
                    'created_at' => Carbon::now()->timestamp,
                    'updated_at' => Carbon::now()->timestamp,
                ]);
            }
        }
    }
    public function showEarningsCountries()
    {
        $records = Country::get();
        return view('admin.reports.countries', compact('records'));
    }
    public function earnings($country)
    {
        //Seller


        $sellers = Seller::get();
        //Shop
        $result = [];
        $sellers_total = [];
        foreach ($sellers as $seller) {
            $total_ = $this->getSellerNeeds($seller->id, null, null, $country);
            $sellers_total[] = [
                $seller->id => $total_
            ];
            $shops =  SalesChannels::where('owner_email', $seller->email)->get();
            foreach ($shops  as $shop) {
                $orders =  Order::where('sales_channel', $shop->id)
                    ->where('country_id', $country)
                    ->where('status', 10)->get();
                $result[] = [
                    'sellers' => $sellers,
                    'shops' => $shops,
                    'orders' => $orders,
                    'seller' => Seller::find($seller->id)
                ];
            }
        }

        return view('admin.reports.earnings', compact('result', 'country', 'sellers', 'sellers_total'));
    }
    function getSellerNeeds($seller, $dateS, $dateE, $country)
    {
        $seller = Seller::find($seller);
        $shops = SalesChannels::where('owner_email', $seller->email)->get();

        $orders = [];
        foreach ($shops as $shop) {
            if (empty($dateS) || empty($dateE)) {
                $orders[] = Order::where('sales_channel', $shop->id)
                    ->where('status', 10)
                    ->where('country_id', $country)
                    ->get();
            } else {
                $orders[] = Order::whereBetween('created_at', [$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])
                    ->where('sales_channel', $shop->id)
                    ->where('country_id', $country)
                    ->where('status', 10)
                    ->get();
            }
        }
        $orders_res = [];
        foreach ($orders as $order) {
            foreach ($order as $ord) {
                $orders_res[] = $ord;
            }
        }
        $orders = $orders_res;
        $total = 0;
        foreach ($orders as $ord) {
            foreach ($ord->product as $pro) {
                $total += intval($pro->price);
            }
        }

        return $total;
    }
    public function earningsFromTo(Request $request, $country)
    {
        //Seller
        $dateS = new Carbon($request->from);
        $dateE = new Carbon($request->to);
        $sellers = Seller::get();
        //Shop
        $result = [];
        $sellers_total = [];
        foreach ($sellers as $seller) {
            $total_ = $this->getSellerNeeds($seller->id, $dateS, $dateE, $country);
            $sellers_total[] = [
                $seller->id => $total_
            ];
            $shops =  SalesChannels::where('owner_email', $seller->email)->get();
            foreach ($shops  as $shop) {
                $orders =  Order::whereBetween('created_at', [$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])
                    ->where('sales_channel', $shop->id)
                    ->where('status', 10)
                    ->where('country_id', $country)
                    ->get();
                $result[] = [
                    'sellers' => $sellers,
                    'shops' => $shops,
                    'orders' => $orders,
                    'seller' => Seller::find($seller->id),
                ];
            }
        }
        return view('admin.reports.earnings', compact('result', 'country', 'sellers', 'sellers_total', 'dateS', 'dateE'));
    }
    public function reports(Request $request, $seller, $type, $country)
    {
        $seller = Seller::find($seller);
        $shops = SalesChannels::where('owner_email', $seller->email)->get();
        $dateS = $request->from;
        $dateE = $request->to;
        $orders = [];
        if ($request->from && $request->from != '' && $request->to && $request->to != '') {
            $from = $request->from;
            $to = $request->to;
            foreach ($shops as $shop) {
                //   $orders = Order::where('sales_channel', $shop->id)->where('status', 10)->whereMonth('created_at', Carbon::now()->month)->get();
                $orders[] = Order::where('sales_channel', $shop->id)
                    ->whereBetween('created_at', [$from, $to])
                    ->where('country_id', $country)
                    ->where('status', 10)->get();
            }
        } else {
            $from = '';
            $to = '';
            foreach ($shops as $shop) {
                //   $orders = Order::where('sales_channel', $shop->id)->where('status', 10)->whereMonth('created_at', Carbon::now()->month)->get();
                $orders[] = Order::where('sales_channel', $shop->id)
                    ->where('status', 10)->where('country_id', $country)->get();
            }
        }
        $orders_res = [];
        foreach ($orders as $order) {
            foreach ($order as $ord) {
                $orders_res[] = $ord;
            }
        }
        $orders = $orders_res;
        if ($type == 'products') {
            $products = [];
            foreach ($orders as $order) {
                $productss = $order->product;
                foreach ($productss as $product) {
                    $products[$product->product_id][] = $product;
                }
            }

            return view('admin.reports.reports', compact('products','country' ,'seller', 'dateS', 'dateE'));
        } else {
            return view('admin.reports.Invoices', compact('orders', 'country', 'seller', 'dateS', 'dateE'));
        }
    }
}

/*$sad ='';
if($shop->created_at == Carbon::now()->format('m/d/Y')) {
    $sad =1;
}else{
    $sad =2;
}
$res = [
    'shop'=>$shop,
    'sad'=>$sad
];
dd($res);*/
