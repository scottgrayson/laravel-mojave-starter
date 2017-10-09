<?php

Route::get('/', 'DashboardController@dashboard')->name('dashboard');

Route::resource('users', 'UserController');
Route::resource('images', 'ImageController');
Route::resource('files', 'FileController');
