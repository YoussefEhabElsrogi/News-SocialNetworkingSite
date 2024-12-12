<?php

use App\Http\Controllers\Api\Account\NotificationController;
use App\Http\Controllers\Api\Account\PostController;
use App\Http\Controllers\Api\Auth\Password\ForgetPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\Password\ResetPasswordController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\PublicSettingController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\RelatedNewsController;
use App\Http\Controllers\Api\Account\SettingController;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group that
| contains the "api" middleware group. Build something great!
|
*/

// **************************** Auth Routes *********************************
Route::prefix('auth')->group(function () {
    // Registration
    Route::post('register', [RegisterController::class, 'register'])->middleware('throttle:register');

    // Login & Logout
    Route::controller(LoginController::class)->group(function () {
        Route::post('login', 'login')->middleware('throttle:login');
        Route::delete('logout', 'logout')->middleware('auth:sanctum');
    });

    // Email Verification
    Route::middleware('auth:sanctum')->prefix('email/verify')->controller(VerifyEmailController::class)->group(function () {
        Route::post('/', 'verifyEmail')->middleware('throttle:verify');
        Route::get('/', 'sendOtpAgain')->middleware('throttle:verify');
    });
});

// ***************************** Forogt Password  ***********************************
Route::controller(ForgetPasswordController::class)->group(function () {
    Route::post('password/email', 'sendOtp');
});

// ***************************** Reset Password  ***********************************
Route::controller(ResetPasswordController::class)->group(function () {
    Route::post('password/reset', 'resetPassword');
});

// ***************************** User Routes ********************************
Route::middleware(['auth:sanctum', 'verifyEmail', 'checkUserStatus'])->prefix('account')->group(function () {

    // User information route
    Route::get('user', function (Request $request) {
        return ApiResponseTrait::sendResponse(200, 'User Information', UserResource::make($request->user()));
    })->middleware('throttle:user');

    // Setting routes
    Route::controller(SettingController::class)->group(function () {
        Route::put('setting/update', 'updateSetting');
        Route::patch('password/update', 'updatePassword');
    });

    // Post-related routes
    Route::controller(PostController::class)->prefix('posts')->group(function () {
        Route::get('/',                      'getUserPosts');
        Route::post('/store',                'storeUserPost');
        Route::delete('/destroy/{post_id}',  'destroyUserPost');
        Route::put('/update/{post_id}',      'updateUserPost');

        // Post comments
        Route::get('/comments/{post_id}',    'getPostComments');
        Route::post('/comments/store',       'StoreComment')->middleware('throttle:comments');
    });

    // Notifications routes
    Route::controller(NotificationController::class)->prefix('notifications')->group(function () {
        Route::get('/', 'getNotifications');
        Route::get('/{id}/read', 'readNotifications');
    });
});

// ***************************** Home Page Routes ***************************
Route::prefix('posts')->controller(GeneralController::class)->group(function () {
    Route::get('/',                 'getPosts');
    Route::post('search/{keyword}', 'searchPosts');
    Route::get('show/{slug}',       'showPost');
    Route::get('comments/{slug}',   'getPostComments');
});

// *************************** Categories Routes ****************************
Route::prefix('categories')->controller(CategoryController::class)->group(function () {
    Route::get('/',              'getCategories');
    Route::get('{slug}/posts',   'getCategoryPosts');
});

// ***************************** Contact Routes *****************************
Route::post('contacts/store', [ContactController::class, 'storeContact'])->middleware('throttle:contacts');

// ***************************** RelatedSites Routes **********************************
Route::get('related-sites',              RelatedNewsController::class);

// ***************************** Settings Routes ****************************
Route::get('settings', [PublicSettingController::class, 'getSettings']);
