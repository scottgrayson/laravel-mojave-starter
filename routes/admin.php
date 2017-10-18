<?php

Route::get('/', 'DashboardController@dashboard')->name('dashboard');

Route::resource('users', 'UserController', ['except' => ['show']]);
Route::resource('camp-dates', 'CampDatesController', ['except' => ['show']]);
Route::resource('reservations', 'ReservationController', ['except' => ['show']]);
Route::resource('campers', 'CamperController');
Route::resource('tents', 'TentController');
Route::resource('images', 'ImageController');
Route::resource('files', 'FileController');
Route::resource('pages', 'PageController');
Route::resource('products', 'ProductController');

// Menu
// order must go before show/edit/update
Route::get('menu-items/order', 'MenuItemController@order')->name('menu-items.order');
Route::post('menu-items/order', 'MenuItemController@reorder')->name('menu-items.reorder');

Route::resource('menu-items', 'MenuItemController');

// Newsletter
Route::post('newsletters/{newsletter}/send', 'NewsletterController@send')->name('newsletter.send');
Route::post('newsletters/{newsletter}/preview', 'NewsletterController@preview')->name('newsletter.preview');

Route::resource('newsletter-subscribers', 'NewsletterSubscriberController', [
    'except' => ['show'],
]);
Route::resource('newsletters', 'NewsletterController');
