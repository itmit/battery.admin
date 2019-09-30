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


Route::group(['as' => 'auth.', 'middleware' => 'auth'], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

    Route::resource('client', 'Web\ClientWebController');

    Route::get('dealer/create', 'Web\ClientWebController@dealerCreate')->name('dealercreate');
    Route::get('seller/create', 'Web\ClientWebController@sellerCreate')->name('sellercreate');
    Route::get('stockman/create', 'Web\ClientWebController@stockmanCreate')->name('stockmancreate');

    Route::get('dealer', 'Web\ClientWebController@dealer')->name('dealer');
    Route::get('seller', 'Web\ClientWebController@seller')->name('seller');
    Route::get('stockman', 'Web\ClientWebController@stockman')->name('stockman');

    Route::post('dealer/store', 'Web\ClientWebController@storeDealer')->name('storeDealer');
    Route::post('seller/store', 'Web\ClientWebController@storeseller')->name('storeSeller');
    Route::post('stockman/store', 'Web\ClientWebController@storestockman')->name('storeStockman');

});

Route::get('checkFiles', 'Web\DeliveryWebController@checkFilesInUploadedFolder')->name('checkFilesInUploadedFolder');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
