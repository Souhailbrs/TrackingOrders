<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\SalesChannels;
use App\Models\Seller;
use App\WorkDayOrder;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    //States
    //=> All
    //=> From , to
    //=> Today
    public function index(Request $request,$type_users){
        //Date that can be
        //All Days
        //Today
        //From to
        if(!$request->date) {
            $date = 'today';
        }else{
            $date = $request->date;
        }
        if(!$request->country) {
            $country = '!';
        }else{
            $country = $request->country;
        }
        if(!$request->city) {
            $city = '!';
        }else{
            $city = $request->city;
        }

        //For all users or for specific user

        //New Orders
        $new_orders = $this->ordersWithState($request, 0, $date,$country,$city,$type_users);
        //Confirmed  Orders
        $confirmed_orders = $this->ordersWithState($request, 4, $date,$country,$city,$type_users);
        //Delivered  Orders
        $delivered_orders = $this->ordersWithState($request, 10, $date,$country,$city,$type_users);
        //Percentage
        //All Orders
        $all_orders = $this->ordersWithState($request, 'all', $date,$country,$city,$type_users);

        if(count($new_orders) > 0) {
            $confirmed_percentage = count($confirmed_orders) / count($new_orders) * 100;
            if ($confirmed_percentage > 100) {
                $confirmed_percentage = 100;
            }
        }else{
            $confirmed_percentage = 0;

        }
        if(count($confirmed_orders) > 0) {
            $delivered_percentage = count($delivered_orders) / count($confirmed_orders) * 100;
            if($delivered_percentage > 100){
                $delivered_percentage = 100;
            }
        }else{
            $delivered_percentage = 0;
        }
        //Total Earnings
        $total_earnings_data = $this->ordersWithState($request, 10, $date,$country,$city,$type_users);
        $total_earnings = 0;
        foreach($total_earnings_data  as $total){
            $total_earnings_products = $total->order->product;
            foreach($total_earnings_products as $pro){
                $total_earnings += $pro->price;
            }
        }
        $graph_earnings =  $this->earningGraph($request, 10, $date,$country,$city,$type_users);
        $countries =  Country::get();
        $cities =  City::get();
        $res= [
            'new_orders'=>count($new_orders),
            'confirmed_orders'=>count($confirmed_orders),
            'delivered_orders'=>count($delivered_orders),
            'confirmed_percentage'=>$confirmed_percentage,
            'delivered_percentage'=>$delivered_percentage,
            'all_orders'=>count($all_orders),
            'total_earnings'=>$total_earnings,
            'graph_earnings'=>$graph_earnings,
            'countries'=>$countries,
            'cities'=>$cities
        ];


        return view('admin.home',compact('res'));
    }

    //Abstract Orders
    public function ordersWithState(Request $request, $status,$state,$country,$city,$type_users){
        $filtered_orders =[];
        $filtered_orders2 = [];
        $filtered_orders3 = [];
        if($status != 'all') {
            $orders = OrderLog::where('status',$status)->get();
        }else{
            $orders = OrderLog::get();
        }
        if($type_users != 'all'){
           $orders= $this->SellerOrders($orders,$type_users);
        }

        if($request->country) {
            foreach ($orders as $order) {
                if ($country != '!') {
                    if ($order->order->country_id == $country) {
                        $filtered_orders2 [] = $order;
                    }
                } else {
                    $filtered_orders2 [] = $order;
                }
            }
        }else {
            foreach ($orders as $order) {
                $filtered_orders2 [] = $order;

            }
        }

        return $this->dateFilter($request,$filtered_orders2,$state);
    }
    public function SellerOrders($orders,$type_user){
        $filtered_orders = [] ;
            $seller = Seller::find($type_user);
            $sales_channels  = SalesChannels::where('owner_email',$seller->email)->get();
            $ids= [];
            foreach($sales_channels as $sale){
                $ids [] = $sale->id;
            }
            foreach ($orders as $order) {
                if(in_array($order->sales_channel,$ids)){
                    $filtered_orders [] = $order;
                }
            }

        return $filtered_orders;
    }
    public function dateFilter(Request $request,$array,$state){
        $result = [];
        foreach($array as $arr) {
            switch ($state) {
                case 'all':
                        $result[] = $arr;
                    break;
                case 'from':
                    $order_date_from = date('Y-m-d', strtotime($request->from));
                    $order_date_to = date('Y-m-d', strtotime($request->to));
                    $order_date = date('Y-m-d', strtotime($arr->created_at));
                    if($order_date >= $order_date_from && $order_date <= $order_date_to){
                        $result[]=$arr;
                    }
                    break;
                case 'today':
                    $order_date_today = date('Y-m-d', strtotime($arr->created_at));
                    $today = date('Y-m-d', strtotime(date('Y-m-d')));
                    if($order_date_today === $today){
                        $result[]=$arr;
                    }
                    break;
            }
        }
        return $result;
    }
    public function getSellerWithOrder($order){
        return Seller::where('email',$order->shop->owner_email)->first()->id;
    }
    //Earnings
    public function earningGraph(Request $request, $status,$state,$country,$city,$type_users){
        //We have 3 cases
        //1. From start till now
        //2. All Days.
        //3. From to date.
        $filtered_orders =[];
        $filtered_orders2 = [];
        $filtered_orders3 = [];
        $result= [];

        if($status != 'all') {
            $orders = OrderLog::where('status',$status)->get();
        }else{
            $orders = OrderLog::get();
        }
        if($type_users != 'all'){
            $orders= $this->SellerOrders($orders,$type_users);
        }

        foreach($orders as $order){
            if($country != '!'){
                if($order->order->country_id == $country){
                    $filtered_orders2 [] = $order;
                }
            }else{
                $filtered_orders2 [] = $order;
            }
        }
        $order_log =  $this->dateFilter($request,$filtered_orders2,$state);
        $real_orders=[];
        foreach($order_log as $orlog){
            $real_orders [] = $orlog->order;
        }
        //Get unique dats
        $days =[];
        foreach($real_orders as $dayUnique){
            $days [] =  date('Y-m-d', strtotime($dayUnique->created_at));
        }
        $days = array_unique($days);


        foreach($days as $day ) {
            foreach ($orders as $order) {
                $order_day = date('Y-m-d', strtotime($order->created_at));
                if($order_day == $day){
                    $result[$day] []= $order;
                }
            }
        }

        foreach($result as $key => $value){
            $orders =  $value;
            $price = 0;
            foreach($orders as $order){
                $products = $order->order->product;
                foreach($products as $pro){
                    $price += $pro->price;
                }
            }
            $result[$key] = $price;
        }

        return $result;

    }



    public function earningGraphOld(Request $request,$filter){
        //We have 3 cases
        //1. From start till now
        //2. All Days.
        //3. From to date.
        $orders = Order::select('id','status','created_at')->where('status',10)->get();
        $result= [];
        $days= [];
        $today = date('Y-m-d', strtotime(date('Y-m-d')));
        if($filter == 'today'){
            foreach($orders as $order){
                $order_date = date('Y-m-d', strtotime($order->created_at));
                if($order_date == $today) {
                    $days [] = $order_date;
                }
            }
        }elseif($filter == 'all'){
            foreach($orders as $order){
                $order_date = date('Y-m-d', strtotime($order->created_at));
                $days [] = $order_date;
            }

        }elseif($filter == 'from'){
            $from = date('Y-m-d', strtotime($request->from));
            $to = date('Y-m-d', strtotime($request->to));
            foreach($orders as $order){
                $order_date = date('Y-m-d', strtotime($order->created_at));
                if($order_date >=  $from && $order_date <= $to) {
                    $days [] = $order_date;
                }
            }
        }

        $days = array_unique($days);
        foreach($days as $day ) {
            foreach ($orders as $order) {
                $order_day = date('Y-m-d', strtotime($order->created_at));
                if($order_day == $day){
                    $result[$day] []= $order;
                }
            }
        }

        foreach($result as $key => $value){
            $orders =  $value;
            $price = 0;
            foreach($orders as $order){
                $products = $order->product;
                foreach($products as $pro){
                    $price += $pro->price;
                }
            }
            $result[$key] = $price;
        }

        return $result;

    }


}
