<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HelperController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */

    public static function getSupporterConfimred($order_id)
    {
        $user = DB::table('user_work_day_orders')
            ->join('supporters', 'supporters.id', '=', 'user_work_day_orders.userID')
            ->select('supporters.*')
            ->where('user_work_day_orders.user_sales_channele_orders', $order_id)
            ->where('user_work_day_orders.userType', 'supporter')
            ->where('user_work_day_orders.status', 1)
            ->first();
        if ($user) {
            return $user->name;
        }
        return null;
    }
    public static function getDelivery($order_id)
    {
        $user = DB::table('user_work_day_orders')
        ->join('deliveries', 'deliveries.id', '=', 'user_work_day_orders.userID')
        ->select('deliveries.*')
        ->where('user_work_day_orders.user_sales_channele_orders', $order_id)
            ->where('user_work_day_orders.userType', 'delivery')
            ->where('user_work_day_orders.status', 1)
            ->first();
        if ($user) {
            return $user->name;
        }
        return null;
    }
    public static function getZoneDelivery($order_id)
    {
        $order = DB::table('sales_channele_orders')
            ->join('zones', 'zones.id', '=', 'sales_channele_orders.zone_id')
            ->select('zones.*')
            ->where('sales_channele_orders.id', $order_id)
            ->first();
        if ($order) {
            return $order->title_en;
        }
        return null;
    }
}
