<?php

namespace App\Http\Controllers\Site;

use App\Admin\District;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\LandingPage;
use App\Models\LandingSection;
use App\Models\OrderTrack;
use App\Models\ProductSeller;
use App\Models\SalesChannels;
use App\Models\UserJoinRequest;
use App\Models\Zone;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    public function AuthRouteAPI(Request $request)
    {
        return $request->user();
    }
}
