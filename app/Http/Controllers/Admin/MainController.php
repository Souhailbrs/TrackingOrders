<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderTrack;
use App\WorkDay;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home(){
        return view('admin.home');
    }
    public function trackOrder($id){
        $records = OrderTrack::where('sales_channele_order',$id)->get();

        return view('admin.orders.track',compact('id','records'));
    }

}
