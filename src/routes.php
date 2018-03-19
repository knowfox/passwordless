<?php

use Knowfox\Passwordless\Controllers\LoginController;
use Knowfox\Passwordless\Controllers\RegisterController;

Route::group(['middleware' => 'web'], function () {
    Route::get('login', LoginController::class . '@showLoginForm')
        ->name('login');

    Route::post('login', LoginController::class . '@login');

    Route::get('register', RegisterController::class . '@showRegistrationForm')->name('register');
    Route::post('register', RegisterController::class . '@register');

    Route::get('cancel/{what}/{email}', [
        'as' => 'cancel',
        'uses' => RegisterController::class . '@cancel',
    ]);

    Route::get('auth/email-authenticate/{token}', [
        'as' => 'auth.email-authenticate',
        'uses' => LoginController::class . '@authenticateEmail',
    ]);

    Route::get('logout', LoginController::class . '@logout')
        ->name('logout');

});

