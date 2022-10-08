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

Route::post('/payment_successfully', 'HomeController@payment_successfully')->name('payment_successfully');
Route::post('/topup_payment_successfully', 'HomeController@topup_payment_successfully')->name('topup_payment_successfully');

Route::post('/upgrade_topup_payment_successfully', 'HomeController@upgrade_topup_payment_successfully')->name('upgrade_topup_payment_successfully');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
