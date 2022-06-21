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
        'prefix' => LaravelLocalization::setLocale() . '/supporter',
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ //...
    Route::get('/', 'MainController@home')->name('home');
    Route::resource('orders', 'OrdersController');
    Route::get('orders/get/{state}/{from}/{to}', 'OrdersController@index')->name('orders.index');

    Route::post('postDate', 'OrdersController@postDate')->name('orders.postDate');
    Route::get('viewWorkDayOrders/{day}', 'OrdersController@viewWorkDayOrders')->name('orders.viewWorkDayOrders');


    Route::get('work/{state}', 'MainController@workState')->name('workState');
    Route::get('get/order', 'SupporterController@getOrder')->name('getOrder');
    Route::get('get/work/days', 'SupporterController@workDays')->name('workDays');

    Route::get('get/worker/available', 'SupporterController@IsUserHasOrder');
    Route::get('get/order/current', 'SupporterController@getCurrentOrder')->name('currentOrder');
    Route::get('get/orders/{state}', 'SupporterController@getAllOrders')->name('getAllOrders');
    Route::post('work/sad', 'MainController@sad')->name('workState.sad');
    Route::get('change_order_state/{order}/{old}/{new}', 'OrdersController@change_order_state')->name('change.order_state');
    Route::get('end_order_work/{order}/{old}/{new}', 'OrdersController@end_order_word')->name('end.order_state');
    Route::get('/get/order/tracks/{id}', 'MainController@trackOrder')->name('site.trackOrder');
    Route::get('tesssssssssst', 'SupporterController@getNextOrder');

});
