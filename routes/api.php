<?php

use Illuminate\Http\Request;

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
Route::post('register', 'Api\AuthController@register');


Route::group(['middleware' => 'auth:api'], function() {
    
});

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