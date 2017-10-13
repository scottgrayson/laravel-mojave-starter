<?php

Route::get('/', 'DashboardController@dashboard')->name('dashboard');

Route::resource('users', 'UserController');
Route::resource('images', 'ImageController');
Route::resource('files', 'FileController');
Route::resource('pages', 'PageController');

// Menu
// order must go before show/edit/update
Route::get('menu-items/order', 'MenuItemController@order')->name('menu-items.order');
Route::post('menu-items/order', 'MenuItemController@reorder')->name('menu-items.reorder');

Route::resource('menu-items', 'MenuItemController');

// Newsletter
Route::get('newsletter/{newsletter}/send', 'NewsletterController@send');
Route::post('newsletter/{newsletter}/preview', 'NewsletterController@preview');
Route::get('newsletter/{newsletter}/statistics', 'NewsletterController@statistics');

Route::resource('newsletter-subscribers', 'NewsletterSubscriberController');
Route::resource('newsletter', 'NewsletterController');
