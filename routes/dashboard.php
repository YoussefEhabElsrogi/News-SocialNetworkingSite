<?php

use App\Http\Controllers\Dashboard\Auth\LoginController;
use App\Http\Controllers\Dashboard\Auth\Passwords\ForgetPasswordController;
use App\Http\Controllers\Dashboard\Auth\Passwords\ResetPasswordController;
use App\Http\Controllers\Dashboard\Authorization\AuthorizationController;
use App\Http\Controllers\Dashboard\Category\CategoryController;
use App\Http\Controllers\Dashboard\Contact\ContactController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\Notification\NotificationController;
use App\Http\Controllers\Dashboard\Post\PostController;
use App\Http\Controllers\Dashboard\Profile\ProfileController;
use App\Http\Controllers\Dashboard\User\UserController;
use App\Http\Controllers\Dashboard\Setting\SettignController;
use App\Http\Controllers\Dashborad\Admin\AdminController;
use App\Http\Controllers\GeneralSearchController;
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

    // Dashboard Routes
    Route::middleware(['auth:admin', 'checkAdminStatus'])->group(function () {

        // Home Route
        Route::get('home', HomeController::class)->name('home');

        Route::resource('authorizations', AuthorizationController::class)->middleware('can:authorizations');

        // User Routes
        Route::resource('users', UserController::class);
        Route::get('users/status/{id}', [UserController::class, 'changeStatus'])->name('users.changeStatus');

        // Category Routes
        Route::resource('categories', CategoryController::class);
        Route::get('categories/status/{id}', [CategoryController::class, 'changeStatus'])->name('categories.changeStatus');

        // Post Routes
        Route::resource('posts', PostController::class);
        Route::get('posts/status/{id}', [PostController::class, 'changeStatus'])->name('posts.changeStatus');
        Route::get('posts/comments/{id}',[PostController::class, 'getAllComments'])->name('posts.getAllComments');
        Route::delete('posts/comment/delete/{id}', [PostController::class, 'deleteComment'])->name('posts.deleteComment');
        Route::post('posts/image/delete/{id}', [PostController::class, 'deletePostImage'])->name('posts.image.delete');

        // ******************** Setting Routes **************************
        Route::controller(SettignController::class)->prefix('settings')->name('settings.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/update', 'update')->name('update');
        });

        // Admin Routes
        Route::resource('admins', AdminController::class);
        Route::get('admins/status/{id}', [AdminController::class, 'changeStatus'])->name('admins.changeStatus');

        //******************** Contact Routes **************************
        Route::controller(ContactController::class)->prefix('contacts')->as('contacts.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/show/{id}', 'show')->name('show');
            Route::get('/destroy/{id}', 'destroy')->name('destroy');
        });

        //******************** Profile Routes **************************
        Route::controller(ProfileController::class)->prefix('profile')->as('profile.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::patch('/update', 'update')->name('update');
        });

        //******************** Notifications Routes **************************
        Route::controller(NotificationController::class)->prefix('notifications')->as('notifications.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/destroy/{id}', 'destroy')->name('destroy');
            Route::get('/delete-all', 'deleteAll')->name('deleteAll');
        });

        //******************** Generl Search Routes **************************
        Route::get('search', [GeneralSearchController::class, 'search'])->name('search');
    });
    //******************** Check Admin Blocked **************************
    Route::get('wait', function () {
        return view('dashboard.wait');
    })->name('wait');
});
