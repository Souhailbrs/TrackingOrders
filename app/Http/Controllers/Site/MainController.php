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
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class MainController extends Controller
{
    public function home()
    {
        $pages = LandingPage::get();
        $sections = LandingSection::get();
        if(Cookie::has('remember_delivery_59ba36addc2b2f9401580f014c7f58ea4e30989d'))
        {
            return redirect()->route('delivery.home', ['filter' => 'today']);
        }

        return view('site.index', compact('pages', 'sections'));
    }
    public function join_us()
    {
        $pages = LandingPage::get();
        $sections = LandingSection::get();
        return view('site.join_us', compact('pages', 'sections'));
    }
    public function JoinRequest(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:sellers',
            'phone' => 'required|unique:sellers|numeric',
        ]);
        UserJoinRequest::create([
            'name' => $request->name,
            'mobile' => $request->phone,
            'email' => $request->email,
            'password' => $request->password,
            'subject' => '',
            'message' => '',
            'state' => 0,
            'times' => 0
        ]);
        return redirect()->back()->with('message', 'لقد استقبلنا طلبك وسنقوم بالتواصل معك في اقرب وقت');
    }
    public function getCities(Request $request)
    {
        $cities = City::where('country_id', $request->country_id)->get();
        return response()->json($cities);
    }
    public function getCitiesWithShop(Request $request)
    {
        $shop = SalesChannels::find($request->shop_id);
        $shop_country_id = $shop->country->id;
        $cities = City::where('country_id', $shop_country_id)->get();
        return response()->json($cities);
    }
    public function getZones(Request $request)
    {
        $zones = Zone::where('city_id', $request->city_id)->get();
        return response()->json($zones);
    }
    public function getDistricts(Request $request)
    {
        $zones = District::where('zone_id', $request->zone_id)->get();
        return response()->json($zones);
    }
    public function getProducts(Request $request)
    {
        $zones = ProductSeller::where('shop_id', $request->shop_id)->get();
        foreach ($zones as $zone) {
            $zone->product_id = $zone->id;
            $zone->product_name = $zone->name;
        }
        return response()->json($zones);
    }
    public function trackOrder($id)
    {
        $records = OrderTrack::where('sales_channele_order', $id)->get();
        return view('seller.orders.tarck', compact('records', 'id'));
    }
}
