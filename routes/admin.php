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
        'prefix' => LaravelLocalization::setLocale() . '/admin',
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ //...
Route::get('/', 'MainController@home')->name('admin.home');
Route::group(['prefix'=>'user','namespace'=>'Users'],function(){
    Route::resource('usersTypes','UserTypesController');
    Route::resource('usersPrivileges','UserPrivilagesController');
    Route::get('users/get/{type}','UsersController@getUsers')->name('users.get.type');
    Route::get('users/get/statistics/{type}/{id}','UsersController@getStatistics')->name('users.get.statistics');
    Route::resource('users','UsersController');
    Route::get('users/edit/{id}/{type}','UsersController@edit')->name('users.edit');
    Route::get('users/delete/{id}/{type}','UsersController@destroy')->name('users.destroy');

});
    Route::get('/UpdateSomeOrders', 'AdvancedController@updateOrdersToBeNewToday');

Route::resource('sellChannels','SellChannelsController');
Route::get('sellChannels/Change/status/{id}','SellChannelsController@ChangeStatus')->name('changeSaleId');

Route::resource('shopTypes','ShopTypeController');

Route::resource('inventories','InventoryController');
Route::get('inventories/show/requests','InventoryController@showRequests')->name('showRequests');
Route::get('inventories/change/requests/status/{state}/{id}','InventoryController@AcceptInv')->name('showRequests.change');


Route::get('joinRequests/{type}','JoinRequests@getRequests')->name('show.requests');
Route::get('joinRequests/change/{requestId}{state}','JoinRequests@ChangeState')->name('change.requests.state');
Route::get('joinRequests/change/accept/{requestId}','JoinRequests@ChangeStateAccept')->name('change.requests.accept');

Route::post('joinRequests/notes','JoinRequests@UpdateNotes')->name('change.requests.notes');
Route::post('joinRequests/file','JoinRequests@UpdateFile')->name('change.requests.file');


Route::resource('joinRequests','JoinRequests');


Route::resource('landingPage','LandingPageController');

Route::resource('orders','OrdersController');
Route::get('orders/get/{state}/{from}/{to}', 'OrdersController@index')->name('admin.orders.index');
    Route::post('postDate', 'OrdersController@postDate')->name('admin.orders.postDate');
    Route::get('change/product/status/{id}','OrdersController@chnageProductStatus')->name('admin.change.product.status');

Route::get('/get/order/tracks/{id}', 'MainController@trackOrder')->name('admin.site.trackOrder');

Route::resource('status','StatusController');
Route::resource('packages','PackagesController');
Route::resource('reports','ReportsController');


Route::resource('countries','CountriesController');
Route::resource('cities','CitiesController');
Route::resource('zones','ZonesController');
Route::get('addAlternative','ZonesController@addAlternative');
Route::get('actionAlternative/{zone_id}/{delivery}/{action}','ZonesController@actionAlternative')->name('zone.actionAlternative');
Route::post('actionAlternativePost','ZonesController@actionAlternativePost')->name('actionAlternativePost');

Route::resource('districts','DistrictsController');
Route::get('/earnings', 'AdvancedController@earnings')->name('earnings');
Route::get('/earnings/reports/{seller}', 'AdvancedController@reports')->name('earnings.reports');


Route::post('/sadstore', 'SalesChannels\SalesChannelsController@store')->name('sad.post');
Route::get('/sad', 'SalesChannels\SalesChannelsController@index')->name('sad.view');
    Route::get('/{type_users}', 'StatisticsController@index')->name('admin.home');

    Route::group(['prefix'=>'landing'],function() {
        Route::get('{name}','LandingPageController@getPage')->name('get.landing');
        Route::post('page','LandingPageController@updatePage')->name('landingPage.update');
        Route::get('add/DevArea','LandingPageController@addFields');
        Route::get('view/allPages','LandingPageController@controlPages')->name('control.pages');
        Route::post('update/allPages','LandingPageController@controlPagesUpdate')->name('control.pages.update');

    });
    Route::group(['prefix'=>'seller'],function() {
        Route::get('products/view','ProductsController@getProducts')->name('get.products');
        Route::get('products/view/{id}','ProductsController@getProductsSeller')->name('get.seller.products');

        Route::get('shipments/view','ProductsController@getShipments')->name('get.shipments');
        Route::get('shipments/view/{id}','ProductsController@getShipmentsSeller')->name('get.seller.shipments');
    });
    Route::post('filter/statistics/{type_users}','StatisticsController@index')->name('filter.statistics');

});
