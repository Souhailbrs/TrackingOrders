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
        'prefix' => LaravelLocalization::setLocale() . '/packaging',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () { //...
    Route::get('/', 'MainController@home')->name('home');
    Route::resource('orders', 'OrdersController');
    Route::post('work/sad', 'MainController@sad')->name('workState.sad');
    Route::resource('wrapping', 'WrappingController');
    Route::resource('boxes', 'BoxesController');

   // Route::get('orders/get/{state}/{from}/{to}', 'WrappingController@index')->name('wrapping.index');
    Route::post('postDate', 'OrdersController@postDate')->name('orders.postDate');
    Route::get('change/product/status/{id}', 'OrdersController@chnageProductStatus')->name('change.product.status');


      Route::get('wrapping/get/today', 'WrappingController@index')->name('wrapping.index');
    Route::get('wrapping/get/sent/{day}/{filter}', 'WrappingController@sentOrders')->name('wrapping.sentOrders');
    Route::get('orders/view/update/{order_id}', 'WrappingController@view_update_page')->name('orders.view.update');
    Route::get('change_order_state_supporter/{order}/{old}/{new}', 'WrappingController@change_order_state_supporter')->name('change.order_state_supporter');

    Route::get('test/{zone_id}', 'WrappingController@getNearestDelivery');
    Route::get('wrapping/addToBoxes/{state}', 'WrappingController@addToBoxes')->name('addToBoxes.index');

    Route::post('select/delivery', 'BoxesController@selectDelivery')->name('box.selectDelivery');
    Route::get('/get/order/tracks/{id}', 'MainController@trackOrder')->name('trackOrder');
    Route::get('change_order_state/{order}/{old}/{new}', 'WrappingController@change_order_state')->name('change.order_state');
    Route::get('change_order_state_all/{state}', 'WrappingController@change_order_state_all')->name('change.order_state.all');

    Route::post('AddOrderToBox', 'WrappingController@addToBox')->name('change.order_state.tobox');
    Route::get('box/order/remove/{id}', 'WrappingController@removeFromBox')->name('box.order.remove');
    Route::get('box/order/status/{id}/{state}', 'WrappingController@BoxStatusChange')->name('box.order.status');

});
