<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\SalesChannels;
use App\Models\Seller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdvancedController extends Controller
{
    public function updateOrdersToBeNewToday(){
        $orders = Order::where('id','>=',1000)->get();

            foreach ($orders as $ord) {
                if($ord->status != 10) {
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
    public function earnings(){
        //Seller


        $sellers = Seller::get();
        //Shop
        foreach($sellers as $seller) {
           $shops =  SalesChannels::where('owner_email',$seller->email)->get();
           foreach($shops  as $shop){
              $orders =  Order::where('sales_channel',$shop->id)->where('status',10)->get();
               $result[] = [
                   'sellers'=>$sellers,
                   'shops'=>$shops,
                   'orders'=>$orders,
                   'seller'=> Seller::find($seller->id)
               ];
           }
        }

        return view('admin.reports.earnings',compact('result','sellers'));
    }
    public function reports($seller){
        $seller = Seller::find($seller);
        $shops =  SalesChannels::where('owner_email',$seller->email)->get();
        $orders =[];
        foreach($shops  as $shop){
             //   $orders = Order::where('sales_channel', $shop->id)->where('status', 10)->whereMonth('created_at', Carbon::now()->month)->get();
               $orders [] = Order::where('sales_channel', $shop->id)->where('status', 10)->get();
        }
        $orders_res = [];
        foreach($orders as $order){
            foreach($order as $ord) {
                $orders_res  [] = $ord;
            }
        }
        $orders = $orders_res;


        return view('admin.reports.reports',compact('orders'));
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
