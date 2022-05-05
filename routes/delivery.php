<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . '/delivery',
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ //...
    Route::get('/{filter}', 'MainController@home')->name('home');
    Route::post('work/sad', 'MainController@sad')->name('workState.sad');
    Route::resource('boxes', 'BoxesController');
    Route::get('boxes/get/boxOrders/{box_id}', 'BoxesController@orders')->name('box.orders');
    Route::get('/get/order/tracks/{id}', 'MainController@trackOrder')->name('trackOrder');
    Route::get('change_order_state/{order}/{old}/{new}', 'MainController@change_order_state')->name('change.order_state');
    Route::post('change_order_state_post', 'MainController@change_order_state_post')->name('change.order_state.post');

});
