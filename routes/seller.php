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
        'prefix' => LaravelLocalization::setLocale() . '/seller',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
        'name' => '.seller'
    ], function () { //...
    Route::get('/home/{type_users}', 'StatisticsController@index')->name('home');

    Route::resource('sellChannels', 'SellChannelsController');
    Route::resource('inventories', 'InventoryController');
    Route::get('inventory/myRequets', 'InventoryController@myRquests')->name('inventory.requests');

    Route::resource('orders', 'OrdersController');
    Route::get('orders/get/{state}/{from}/{to}', 'OrdersController@index')->name('orders.index');
    Route::post('postDate', 'OrdersController@postDate')->name('orders.postDate');

    Route::post('orders/get/import', 'OrdersController@import')->name('import.orders');

    Route::get('orders/get/hide/{id}/{state}', 'OrdersController@hide')->name('hide.order');
    Route::get('product/get/hide/{id}/{state}', 'OrdersController@hideProduct')->name('hide.product');

    Route::post('orders/import/data/orders/{day}', 'OrdersController@viewWorkDayOrders')->name('view.viewWorkDayOrders');
    Route::get('orders/filter/products/{state}', 'OrdersController@filterOrdersWithShop')->name('view.filterOrdersWithShop');

    Route::resource('products', 'ProductsController');
    Route::get('DelproductAjax','ProductsController@DelproductAjax')->name('products.destroy.redeny.ajax');
    Route::get('Delproduct/{id}','ProductsController@Delproduct')->name('products.destroy.redeny');
    Route::post('filter/statistics/{type_users}','StatisticsController@index')->name('filter.statistics');

});
