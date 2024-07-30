<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\ColorController;
use \App\Http\Controllers\OrderController;
use \App\Http\Controllers\PlantController;
use \App\Http\Controllers\SlideController;
use App\Http\Controllers\StripeController;
use \App\Http\Controllers\BannerController;
use \App\Http\Controllers\ReviewController;
use \App\Http\Controllers\AppUserController;
use \App\Http\Controllers\PotTypeController;
use \App\Http\Controllers\SymptomController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\PlantMedController;
use \App\Http\Controllers\PlantTypeController;
use \App\Http\Controllers\PromocodeController;
use \App\Http\Controllers\PromotionController;
use App\Http\Controllers\PurchaseVerificationController;

Route::middleware('authApi')->group(function () {
    Route::get('/users', [AppUserController::class, 'index']);
    Route::post('/user-by-email', [AppUserController::class, 'findUserByEmail']);
    Route::get('/plants', [PlantController::class, 'index']);
    Route::get('/plantmed', [PlantMedController::class, 'index']);
    Route::get('/slides', [SlideController::class, 'index']);
    Route::get('/colors', [ColorController::class, 'index']);
    Route::get('/banners', [BannerController::class, 'index']);
    Route::get('/pot/types', [PotTypeController::class, 'index']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/symptoms', [SymptomController::class, 'index']);
    Route::get('/promotions', [PromotionController::class, 'index']);
    Route::get('/promocodes', [PromocodeController::class, 'index']);

    Route::get('/order/{userId}', [OrderController::class, 'index']);
    Route::get('/plant/types', [PlantTypeController::class, 'index']);
    Route::get('/reviews/{productId}', [ReviewController::class, 'index']);
    Route::get('/user/{userId}', [AppUserController::class, 'show']);

    Route::put('/user/update/{userId}', [AppUserController::class, 'update']);

    Route::post('/order/create', [OrderController::class, 'create']);
    Route::post('/user/create', [AppUserController::class, 'create']);
    Route::post('/user/login', [AppUserController::class, 'login']);
    Route::post('/review/create', [ReviewController::class, 'create']);
    Route::post('/promocode/show', [PromocodeController::class, 'show']);
    Route::post('/send/otp/email', [AppUserController::class, 'sendEmailOtp']);
    Route::post('/send/otp/phone', [AppUserController::class, 'sendPhoneOtp']);
    Route::post('/change/password', [AppUserController::class, 'changePassword']);
    Route::post('/verify/otp/phone', [AppUserController::class, 'verifyPhoneOtp']);
    Route::post('/verify/otp/email', [AppUserController::class, 'verifyEmailOtp']);

    Route::delete('/user/delete/{userId}', [AppUserController::class, 'deleteUser']);
    Route::put('/update-user-is-prenium/{userId}', [AppUserController::class, 'isPremium']);

    Route::post('/validate-receipt', [PurchaseVerificationController::class, 'validateReceipt']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
