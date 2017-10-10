<?php

Route::get('/', 'DashboardController@dashboard')->name('dashboard');

Route::resource('users', 'UserController');
Route::resource('images', 'ImageController');
Route::resource('files', 'FileController');

// Menu
Route::resource('menu-items', 'MenuItemController');
Route::resource('menu-item-order', 'MenuItemOrderController', [
    'only' => ['index', 'store'],
]);
