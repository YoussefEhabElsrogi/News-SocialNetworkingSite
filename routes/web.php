<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\Dashboard\ProfileController;
use App\Http\Controllers\Frontend\Dashboard\SettingController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewSubscriberController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\SearchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');

Route::group(['as' => 'front.'], function () {

    // Home Route
    Route::get('/home', [HomeController::class, 'index'])
        ->name('index');

    // News Subscription
    Route::post('news-subscribe', [NewSubscriberController::class, 'store'])
        ->name('news.subscribe.store');

    // Category Routes
    Route::get('category/{slug}', CategoryController::class)
        ->name('category.posts');

    // Post Routes
    Route::prefix('post')->name('post.')->group(function () {
        Route::get('{slug}', [PostController::class, 'show'])
            ->name('show');
        Route::get('comments/{slug}', [PostController::class, 'getAllComments'])
            ->name('comments');
        Route::post('comments', [PostController::class, 'storeComment'])
            ->name('comment.store');
    });

    // Contact Routes
    Route::prefix('contact')->name('contact.')->group(function () {
        Route::get('us', [ContactController::class, 'create'])
            ->name('create');
        Route::post('/', [ContactController::class, 'store'])
            ->name('store');
    });

    // Search Routes
    Route::match(['get', 'post'], 'search', SearchController::class)
        ->name('search');

    // Dashboard Routes
    Route::prefix('user')->name('dashboard.')->middleware(['auth', 'verified'])->group(function () {
        Route::controller(ProfileController::class)->group(function () {
            Route::get('profile', 'index')->name('profile');
            Route::prefix('post')->name('post.')->group(function () {
                Route::post('store', 'storePost')->name('store');
                Route::delete('delete/{slug}', 'deletePost')->name('delete');
                Route::get('get-comments/{slug}', action: 'getComments')->name('get-comments');
                Route::get('edit/{slug}', 'showEditForm')->name('edit');
                Route::put('update', 'updatePost')->name('update');
                Route::post('image/delete/{id}','deletePostImage')->name('image.delete');
            });
        });
        // Settings Routes
        Route::controller(SettingController::class)->prefix('setting')->name('setting.')->group(function () {
            Route::get('', 'index')->name('index');
            Route::put('/update', 'update')->name('update');
            Route::post('/change-password', 'changePassword')->name('change-password');
        });
    });
});

// Email Verification Routes
Route::prefix('email')->name('verification.')->controller(VerificationController::class)->group(function () {
    Route::get('verify', 'show')->name('notice');
    Route::get('verify/{id}/{hash}', 'verify')->name('verify');
    Route::post('resend', 'resend')->name('resend');
});

// Authentication Routes
Auth::routes();
