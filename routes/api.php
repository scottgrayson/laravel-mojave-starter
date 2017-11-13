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

Route::get('/reservations/{tent}', 'ReservationController@tentReservations');
Route::resource('reservations', 'ReservationController');
Route::resource('availabilities', 'AvailabilityController');

Route::resource('cart-items', 'CartItemController');
Route::resource('tents', 'TentController');
Route::resource('camp-dates', 'CampDateController');

Route::post('payments', 'PaymentController@store')->name('payments.store');
