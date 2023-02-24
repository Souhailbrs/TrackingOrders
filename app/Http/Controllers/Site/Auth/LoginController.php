<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\models\City;
use App\Models\LandingPage;
use App\Models\LandingSection;
use App\Providers\RouteServiceProvider;
use Cookie;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie as FacadesCookie;
use Symfony\Component\HttpFoundation\Cookie as HttpFoundationCookie;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    public function showLoginForm()
    {
        $pages = LandingPage::get();
        $sections = LandingSection::get();
        if (Cookie::has('remember_delivery_59ba36addc2b2f9401580f014c7f58ea4e30989d')) {
            return redirect()->route('delivery.home', ['filter' => 'today']);
        }
        return view('auth.login', compact('pages', 'sections'));
    }

    public function UserLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            config()->set('auth.defaults.guard', 'admin');
            $status = auth()->user()->status;
            if ($status == 0) {
                return redirect()->route('auth.login')->withErrors(['msg' => 'Your Account Is Banned Contact Support !']);
            }
            $this->id = auth()->user()->id;
            //return 1;
            // if successful, then redirect to their intended location
            return redirect()->route('admin.home', ['type_users' => 'all']);
        }
        if (Auth::guard('seller')->attempt(['email' => $request->email, 'password' => $request->password])) {
            config()->set('auth.defaults.guard', 'seller');
            $status = auth()->user()->status;
            if ($status == 0) {
                return redirect()->route('auth.login')->withErrors(['msg' => 'Your Account Is Banned Contact Support !']);
            }
            $this->id = auth()->user()->id;
            // if successful, then redirect to their intended location
            //return redirect()->route('vendor.profile-index',['type'=>'vendor','id'=>$this->id]);
            return redirect()->route('seller.home', ['type_users' => auth()->user()->id]);
        }
        if (Auth::guard('delivery')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            config()->set('auth.defaults.guard', 'delivery');
            $status = auth()->user()->status;
            if ($status == 0) {
                return redirect()->route('auth.login')->withErrors(['msg' => 'Your Account Is Banned Contact Support !']);
            }
            $this->id = auth()->user()->id;
            # boolean true
            //return redirect()->route('maintenance.profile-index',['type'=>'maintenance','id'=>$this->id]);
            // if successful, then redirect to their intended location
            //return redirect()->route('admin.home');

            return redirect()->route('delivery.home', ['filter' => 'today']);
        }
        if (Auth::guard('supporter')->attempt(['email' => $request->email, 'password' => $request->password])) {
            config()->set('auth.defaults.guard', 'supporter');
            $status = auth()->user()->status;
            if ($status == 0) {
                return redirect()->route('auth.login')->withErrors(['msg' => 'Your Account Is Banned Contact Support !']);
            }
            $this->id = auth()->user()->id;
            //return redirect()->route('maintenance.profile-index',['type'=>'maintenance','id'=>$this->id]);
            // if successful, then redirect to their intended location
            //return redirect()->route('admin.home');
            
            return redirect()->route('supporter.home', ['type_users' => auth()->user()->id]);
        }
        if (Auth::guard('packaging')->attempt(['email' => $request->email, 'password' => $request->password])) {
            config()->set('auth.defaults.guard', 'packaging');
            $status = auth()->user()->status;
            if ($status == 0) {
                return redirect()->route('auth.login')->withErrors(['msg' => 'Your Account Is Banned Contact Support !']);
            }
            $this->id = auth()->user()->id;
            //return redirect()->route('maintenance.profile-index',['type'=>'maintenance','id'=>$this->id]);
            // if successful, then redirect to their intended location
            //return redirect()->route('admin.home');
            return redirect()->route('packaging.home');
        }

        return redirect()->route('auth.login')->withErrors(['msg' => 'Make Sure you entered correct credentials']);
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        Auth::guard('seller')->logout();
        Auth::guard('delivery')->logout();
        Auth::guard('supporter')->logout();
        Auth::guard('packaging')->logout();

        return redirect()->back();
    }
}
