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

// Newsletter Subscribe
Route::get('newsletter', 'NewsletterSubscriberController@create')->name('newsletter.create');
Route::post('newsletter', 'NewsletterSubscriberController@store')->name('newsletter.store');
Route::get('newsletter/unsubscribe', 'NewsletterSubscriberController@unsubscribe')->name('newsletter.unsubscribe');
Route::delete('newsletter/unsubscribe', 'NewsletterSubscriberController@destroy')->name('newsletter.destroy');
// Newsletter Tracking
Route::get('newsletters/short/{slug}', 'NewsletterTrackingController@link');
Route::get('newsletters/open/{id}', 'NewsletterTrackingController@open');

Route::get('calendar', 'CalendarController@index')->name('calendar.index');

Route::middleware('auth')->group(function () {
    Route::get('notifications/mark-read', 'NotificationController@markAllRead');

    Route::resource('notifications', 'NotificationController', [
        'only' => ['index', 'show'],
    ]);

    // Users
    Route::get('settings', 'UserController@settings')->name('settings');
    Route::resource('users', 'UserController', [
        'only' => ['update'],
    ]);

    Route::resource('campers', 'CamperController');

    Route::delete('cart', 'CartController@destroy')->name('cart.destroy');

    Route::resource('cart', 'CartController', [
        'only' => ['index'],
    ]);
});
