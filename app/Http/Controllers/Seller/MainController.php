<?php

namespace App\Http\Controllers\Seller;

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

class MainController extends Controller
{
    // public function home(){
    //     return view('seller.home');
    // }
        public function home()
    {
        return view('seller.home');
    }
}
