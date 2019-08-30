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

    // Route::resource('client', 'Web\ClientWebController');

    Route::post('dealer/create', 'Web\ClientWebController@dealerCreate');
    Route::post('seller/create', 'Web\ClientWebController@sellerCreate');
    Route::post('stockman/create', 'Web\ClientWebController@stockmanCreate');

    Route::get('dealer', 'Web\ClientWebController@dealer');
    Route::get('seller', 'Web\ClientWebController@seller');
    Route::get('stockman', 'Web\ClientWebController@stockman');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
