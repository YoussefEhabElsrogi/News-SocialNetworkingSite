<?php

use App\Http\Controllers\Dashboard\Auth\LoginController;
use App\Http\Controllers\Dashboard\Auth\Passwords\ForgetPasswordController;
use App\Http\Controllers\Dashboard\Auth\Passwords\ResetPasswordController;
use App\Http\Controllers\Dashboard\Category\CategoryController;
use App\Http\Controllers\Dashboard\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->name('dashboard.')->group(function () {

    // Authentication Routes
    Route::controller(LoginController::class)->group(function () {
        // Guest Routes
        Route::middleware('guest:admin')->name('login.')->group(function () {
            Route::get('login', 'showLoginForm')->name('show');
            Route::post('login', 'checkAuth')->name('check');
        });

        // Password Management Routes
        Route::prefix('password')->name('password.')->group(function () {
            Route::controller(ForgetPasswordController::class)->group(function () {
                Route::get('email', 'showEmailForm')->name('email');
                Route::post('email', 'sendOtp')->name('sendOtp');
                Route::get('verify/{email}', 'showOtpForm')->name('showOtpForm');
                Route::post('verify', 'verifyOtp')->name('verifyOtp');
            });

            Route::controller(ResetPasswordController::class)->group(function () {
                Route::get('reset/{email}', 'showResetForm')->name('resetForm');
                Route::post('reset', 'resetPassword')->name('resetPassword');
            });
        });

        // Logout Route
        Route::middleware('auth:admin')->post('logout', 'logout')->name('logout');
    });

    // Protected Routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('home', function () {
            return view('dashboard.index');
        })->name('home');

        // User Routes
        Route::resource('users', UserController::class);
        Route::get('users/status/{id}', [UserController::class, 'changeStatus'])->name('users.changeStatus');

        // Category Routes
        Route::resource('categories', CategoryController::class);
        Route::get('categories/status/{id}', [CategoryController::class, 'changeStatus'])->name('categories.changeStatus');
    });
});
