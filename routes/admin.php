<?php

Route::get('/', 'DashboardController@dashboard')->name('dashboard');

Route::resource('users', 'UserController', ['except' => ['show']]);
Route::resource('camps', 'CampController', ['except' => ['show']]);
Route::resource('event-types', 'EventTypeController', ['except' => ['show']]);
Route::resource('events', 'EventController', ['except' => ['show']]);
Route::resource('reservations', 'ReservationController', ['except' => ['show']]);
Route::resource('payments', 'PaymentController', ['only' => ['index', 'show', 'destroy']]);
Route::resource('refunds', 'RefundController', ['only' => ['index', 'store']]);
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
Route::resource('counselors', 'CounselorController', ['except' => 'show']);

// Newsletter
Route::post('newsletters/{newsletter}/send', 'NewsletterController@send')->name('newsletter.send');
Route::post('newsletters/{newsletter}/preview', 'NewsletterController@preview')->name('newsletter.preview');

Route::resource('newsletter-subscribers', 'NewsletterSubscriberController', [
    'except' => ['show'],
]);
Route::resource('newsletters', 'NewsletterController');
