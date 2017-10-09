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

Route::middleware('guest')->group(
    function () {
        Route::post('login', 'Auth\LoginController@login');
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    }
);

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'HomeController@welcome')->name('welcome');

Route::middleware('auth')->group(
    function () {
        Route::get('home', 'HomeController@home')->name('home');

        Route::get('notifications/mark-read', 'NotificationController@markAllRead');

        Route::resource(
            'notifications', 'NotificationController', [
            'only' => ['index', 'show'],
            ]
        );
    }
);
