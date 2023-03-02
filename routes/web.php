<?php

use App\Http\Controllers\Site\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/has', function () {
    return Hash::make('codafricann102022');
});
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () { //...
        Route::get('/', 'MainController@home')->name('site.home');

        Route::get('/get/shops/products', 'MainController@getProducts')->name('site.getProducts');
        Route::get('/get/country/cities', 'MainController@getCities')->name('site.getCities');
        Route::get('/get/country/cities/withShop', 'MainController@getCitiesWithShop')->name('site.getCities.withShopId');

        Route::get('/get/cities/zones', 'MainController@getZones')->name('site.getZones');
        Route::get('/get/cities/districts', 'MainController@getDistricts')->name('site.getDistricts');

        Route::get('/get/order/tracks/{id}', 'MainController@trackOrder')->name('site.trackOrder');


        Route::get('/join_us', 'MainController@join_us')->name('site.join_us');
        Route::get('view/login', 'Auth\LoginController@showLoginForm')->name('auth.login');
        Route::post('login/post', 'Auth\LoginController@UserLogin')->name('auth.login.post');
        Route::get('logout', 'Auth\LoginController@logout')->name('logout');

        Route::post('send/join/request', 'MainController@JoinRequest')->name('send.join.request');

        Route::get('/tessssssssssssssssst', function () {
            return view('layouts.admin2');
        });

        Route::get('/home', 'MainController@index')->name('home');
        Route::get('/clear-cache', function () {
            Artisan::call('cache:clear');
            Artisan::call('config:cache');
            return 'DONE'; //Return anything
        });

        Auth::routes();
        Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
        Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
        Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
        Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

        Route::get('/home', 'MainController@index')->name('home');

        Route::get('/DeleteAllSellerOrders', function () {
            $sales = \App\Models\SalesChannels::get();
            foreach ($sales as $sale) {
                $orders = \App\Models\Order::where('sales_channel', $sale->id)->get();
                foreach ($orders as $ord) {
                    $products = $ord->product;
                    foreach ($products as $pro) {
                        $pro->delete();
                    }
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
                    $ord->delete();
                }
            }
        });

        Route::post('customOrdersProduct/{action}/{order_id}', 'CustomOrdersController@OrderProducsActions')->name('customOrder.actions');
        Route::post('addProductOrder', 'CustomOrdersController@addProductOrder')->name('addProductOrder');
        Route::get('removeProductOrder/{id}', 'CustomOrdersController@removeProductOrder')->name('removeProductOrder');
        Route::get('change_order_state', 'CustomOrdersController@change_order_state')->name('change_order_state');
        Route::get('change_order_product_details', 'CustomOrdersController@change_order_product_details')->name('change_order_product_details');

        Route::get('custom_orders_export/{pagination}', 'CustomOrdersController@exportOrders')->name('custom_orders_export');
        Route::get('customOrders/{pagination}', 'CustomOrdersController@exportOrders')->name('custom_orders_export');
        Route::resource('customOrders', 'CustomOrdersController');
    }
);
//
