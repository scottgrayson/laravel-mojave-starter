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

Route::resource('reservations', 'ReservationController', ['only' => ['index']]);
Route::resource('availabilities', 'AvailabilityController', ['only' => ['index']]);
Route::resource('events', 'EventController', ['only' => ['index']]);

Route::resource('cart-items', 'CartItemController', ['only' => ['index', 'store', 'destroy']]);

Route::post('payments', 'PaymentController@store')->name('payments.store');
