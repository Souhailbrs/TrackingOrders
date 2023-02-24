<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\SalesChannels;
use Config;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderssExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public static $pagination = 5;
    public function collection()
    {
        if (Auth::guard('seller')->check()) {
            $user_email = Auth::guard('seller')->user()->email;
            $shopTypes = SalesChannels::where('owner_email', $user_email)->get();
        } else {
            $shopTypes = SalesChannels::get();
        }
        $records = [];
        $shops = [];
        foreach ($shopTypes as $shop) {
            $shops[] = $shop->id;
        }
        return Order::whereIn('sales_channel', $shops)->take(self::$pagination)->get();
    }
}

