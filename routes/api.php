<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'Api\AuthController@login');
// Route::post('register', 'Api\AuthController@register');


Route::group(['middleware' => 'auth:api'], function() {
    // Route::post('details', 'Api\ClientController@details');

    Route::get('delivery/listOfDealers', 'Api\DeliveryApiController@listOfDealers');
    Route::get('delivery/listOfDeliveries', 'Api\DeliveryApiController@listOfDeliveries');
    Route::post('delivery/store', 'Api\DeliveryApiController@store');

    Route::post('shipment/store', 'Api\ShipmentApiController@store');

    Route::get('news/index/{limit}/{offset}', 'Api\NewsApiController@index');

    Route::get('checkDeliveryAndShipment/listOfDeliveries', 'Api\CheckDeliveryAndShipmentController@getDeliveries');
    Route::get('checkDeliveryAndShipment/listOfShipments', 'Api\CheckDeliveryAndShipmentController@getShipments');
    Route::get('checkDeliveryAndShipment/listOfDeliveriesAndShipments', 'Api\CheckDeliveryAndShipmentController@getDeliveriesAndShipments');
});

Route::post('delivery/checkBattery', 'Api\DeliveryApiController@checkBattery');

Route::fallback(function () {
    $code = 404;
    $response = [
        'success' => false,
        'message' => 'Page not found',
    ];

    return response()->json($response, $code);
});

Route::any('{url?}/{sub_url?}', function(){
    $code = 404;
    $response = [
        'success' => false,
        'message' => 'Page not found',
    ];

    return response()->json($response, $code);
});
