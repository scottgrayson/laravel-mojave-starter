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

Route::resource('reservations', 'ReservationController');
Route::resource('availabilities', 'AvailabilityController');

Route::resource('cart-items', 'CartItemController');
Route::resource('tents', 'TentController');
Route::resource('camp-dates', 'CampDateController');
