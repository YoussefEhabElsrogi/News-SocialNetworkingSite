<?php

use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewSubscriberController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\SearchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['as' => 'front.'], function () {

    // Home Route
    Route::get('/', [HomeController::class, 'index'])->name('index');

    // News Subscription
    Route::post('news-subscribe', [NewSubscriberController::class, 'store'])->name('news.subscribe.store');

    // Category Routes
    Route::get('category/{slug}', CategoryController::class)->name('category.posts');

    // Post Routes
    Route::prefix('post')->name('post.')->group(function () {
        Route::get('{slug}', [PostController::class, 'show'])->name('show');
        Route::get('comments/{slug}', [PostController::class, 'getAllComments'])->name('comments');
        Route::post('comments', [PostController::class, 'storeComment'])->name('comment.store');
    });

    // Contact Routes
    Route::controller(ContactController::class)->name('contact.')->group(function () {
        Route::get('contact-us', 'create')->name('create');
        Route::post('contact', 'store')->name('store');
    });

    // Search Routes
    Route::match(['get', 'post'], 'search', SearchController::class)->name('search');
});

Auth::routes();
