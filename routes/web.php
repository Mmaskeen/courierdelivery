<?php

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

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/clear-cache', function() {
    Artisan::call('optimize:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return redirect()->back()->with('success','Cache has been cleared');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'],function () {
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
    Route::get('/profile','ProfileController@myProfile')->name('edit-profile');
    Route::put('/update/profile/{id}','ProfileController@update')->name('update-profile');
});

Route::group(['middleware' => ['auth','admin'],'prefix' => 'admin','namespace' => 'Admin'],function () {

    Route::group(['prefix' => 'dashboard'],function (){
        Route::get('/', 'DashboardController@index')->name('admin_dashboard');
    });

    Route::group(['prefix' => 'order'],function (){


        Route::put('/change-dispatch-order-status/{id}','OrderController@changeDispatchOrder')->name('admin_change_dispatch_order_status');
        Route::post('/received-parcel/{id}','OrderController@receiveParcel')->name('admin_received_parcel');

        Route::get('/invoice/{id}', 'OrderController@invoice')->name('admin_get_invoice');
        Route::get('/sync-records', 'OrderController@syncRecords')->name('admin_sync_record');
        Route::get('/all-order', 'OrderController@allOrder')->name('admin_all_order');
        Route::get('/trashed-order', 'OrderController@trashedOrder')->name('admin_trashed_order');
        Route::get('/check-orders', 'OrderController@filterOrder')->name('admin_filter_dashboard_order');

        Route::get('/filter-order', 'OrderController@allOrder')->name('admin_filter_order');
        Route::get('/add-order', 'OrderController@create')->name('admin_add_order');
        Route::get('/search-order', 'OrderController@searchOrder')->name('admin_search_order');
        Route::post('/store-order', 'OrderController@store')->name('admin_store_order');
        Route::get('/edit-order/{id}', 'OrderController@edit')->name('admin_edit_order');
        Route::get('/new-order/{id}', 'OrderController@newOrder')->name('admin_new_order');
        Route::put('/update-order/{id}', 'OrderController@update')->name('admin_update_order');
        Route::post('/update-order-status/{id}', 'OrderController@updateStatus')->name('admin_update_order_status');
        Route::get('/view-order-status/{id}', 'OrderController@viewOrderStatus');
        Route::post('/restore-orders', 'OrderController@restoreOrder')->name('admin_restore_order');
        Route::delete('/delete-order/{id}', 'OrderController@destroy')->name('admin_delete_order');
        Route::delete('/delete-multiple-order', 'OrderController@deleteMultiple')->name('admin_delete_multiple_order');
        Route::delete('/delete-order-permanently', 'OrderController@deletePermanent')->name('admin_delete_order_permanent');

        Route::post('export', 'OrderController@export')->name('export');
        Route::get('/sorting-orders', 'OrderController@sortingOrder')->name('admin_sorting_order');

        Route::get('today/dispatch-orders','OrderController@todayDispatchOrders')->name('admin_dispatch_orders');


    });

    Route::group(['prefix' => 'user'],function (){

        Route::get('/all-user', 'UserController@allUser')->name('admin_all_user');
        Route::get('/add-user', 'UserController@create')->name('admin_add_user');
        Route::post('/store-user', 'UserController@store')->name('admin_store_user');
        Route::get('/edit-user/{id}', 'UserController@edit')->name('admin_edit_user');
        Route::put('/update-user/{id}', 'UserController@update')->name('admin_update_user');
        Route::delete('/delete-user/{id}', 'UserController@destroy')->name('admin_delete_user');

    });

    Route::group(['prefix' => 'rider'],function (){

        Route::get('/all-rider', 'RiderController@index')->name('admin_all_rider');
        Route::get('/add-rider', 'RiderController@create')->name('admin_add_rider');
        Route::post('/store-rider', 'RiderController@store')->name('admin_store_rider');
        Route::get('/edit-rider/{id}', 'RiderController@edit')->name('admin_edit_rider');
        Route::put('/update-rider/{id}', 'RiderController@update')->name('admin_update_rider');
        Route::delete('/delete-rider/{id}', 'RiderController@destroy')->name('admin_delete_rider');

    });

    Route::group(['prefix' => 'city'],function (){

        Route::get('dispatch/city', 'CityController@dispatchCity')->name('admin_get_dispatch_city');
        Route::get('/all-city', 'CityController@allCity')->name('admin_all_city');
        Route::get('/add-city', 'CityController@create')->name('admin_add_city');
        Route::post('/store-city', 'CityController@store')->name('admin_store_city');
        Route::get('/edit-city/{id}', 'CityController@edit')->name('admin_edit_city');
        Route::put('/update-city/{id}', 'CityController@update')->name('admin_update_city');
        Route::delete('/delete-city/{id}', 'CityController@destroy')->name('admin_delete_city');

    });

    Route::get('/report', 'ReportController@report')->name('admin_report');
    Route::get('staff/activities/{id}','ReportController@staffActivitiesReport');
    Route::get('sales/report/{data}','ReportController@salesReport')->name('admin_sales_report');
});

Route::group(['middleware' => ['auth','employee'],'prefix' => 'employee','namespace' => 'Employee'],function () {

    Route::group(['prefix' => 'dashboard'],function (){
        Route::get('/', 'DashboardController@index')->name('employee_dashboard');
    });

    Route::group(['prefix' => 'order'],function (){

        Route::put('/change-dispatch-order-status/{id}','OrderController@changeDispatchOrder')->name('employee_change_dispatch_order_status');
        Route::post('/received-parcel/{id}','OrderController@receiveParcel')->name('employee_received_parcel');

        Route::get('/sync-records', 'OrderController@syncRecord')->name('employee_sync_record');

        Route::get('/all-order', 'OrderController@allOrder')->name('employee_all_order');
        Route::get('/trashed-order', 'OrderController@trashedOrder')->name('employee_trashed_order');
        Route::get('/check-orders', 'OrderController@filterOrder')->name('employee_filter_dashboard_order');

        Route::get('/filter-order', 'OrderController@allOrder')->name('employee_filter_order');
        Route::get('/add-order', 'OrderController@create')->name('employee_add_order');
        Route::get('/search-order', 'OrderController@searchOrder')->name('employee_search_order');
        Route::post('/store-order', 'OrderController@store')->name('employee_store_order');
        Route::get('/edit-order/{id}', 'OrderController@edit')->name('employee_edit_order');
        Route::get('/new-order/{id}', 'OrderController@newOrder')->name('employee_new_order');
        Route::put('/update-order/{id}', 'OrderController@update')->name('employee_update_order');
        Route::post('/update-order-status/{id}', 'OrderController@updateStatus')->name('employee_update_order_status');
        Route::get('/view-order-status/{id}', 'OrderController@viewOrderStatus');
        Route::post('/restore-orders', 'OrderController@restoreOrder')->name('employee_restore_order');
        Route::delete('/delete-order/{id}', 'OrderController@destroy')->name('employee_delete_order');
        Route::delete('/delete-multiple-order', 'OrderController@deleteMultiple')->name('employee_delete_multiple_order');
        Route::delete('/delete-order-permanently', 'OrderController@deletePermanent')->name('employee_delete_order_permanent');

        Route::get('/sorting-orders', 'OrderController@sortingOrder')->name('employee_sorting_order');

        Route::get('today/dispatch-orders','OrderController@todayDispatchOrders')->name('employee_dispatch_orders');
    });

    Route::group(['prefix' => 'city'],function (){

        Route::get('/dispatch/city', 'CityController@dispatchCity')->name('employee_get_dispatch_city');

        Route::get('/all-city', 'CityController@allCity')->name('employee_all_city');
        Route::get('/add-city', 'CityController@create')->name('employee_add_city');
        Route::post('/store-city', 'CityController@store')->name('employee_store_city');
        Route::get('/edit-city/{id}', 'CityController@edit')->name('employee_edit_city');
        Route::put('/update-city/{id}', 'CityController@update')->name('employee_update_city');
        Route::delete('/delete-city/{id}', 'CityController@destroy')->name('employee_delete_city');

    });

});

Route::get('notification/mark/read','HomeController@markNotificationRead')->name('read_notification');
//Route::get('/get-tcs-city','HomeController@getTcsCity')->name('get-tcs-city');
//Route::get('/get-stallion-city','HomeController@getStallionCity')->name('get-stallion-city');
Route::get('post/order/stallion','HomeController@postOrderStallion')->name('post_order_stallion');
Route::get('order/invoice', function () {
    return view('invoice.invoice');
});
