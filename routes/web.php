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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::middleware('auth')->group( function () {
    Route::get('notifications/mark-read', 'NotificationController@markAllRead');

    Route::resource('notifications', 'NotificationController', [
        'only' => ['index', 'show'],
    ]);

    // Users
    Route::get('settings', 'UserController@settings')->name('settings');
    Route::resource('users', 'UserController', [
        'only' => ['update'],
    ]);
});
