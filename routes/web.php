<?php

use App\Http\Controllers\FrontEnd\HomeController;
use App\Http\Controllers\Frontend\NewSubscriberController;
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
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::post('news-subscribe', [NewSubscriberController::class, 'store'])->name('news.subscribe.store');
});

Auth::routes();
