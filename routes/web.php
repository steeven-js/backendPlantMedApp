<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;

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


Route::redirect('/', '/dev/login');
Route::get('/stripe/success', [StripeController::class, 'handleSuccess'])->name('stripe.success');
Route::get('/test', [App\Http\Controllers\Tests\TestsController::class, 'index']);
// Route::get('/test1', [App\Http\Controllers\Tests\SyptomByPlantController::class, 'index']);
Route::get('/test2', [App\Http\Controllers\Tests\ImagePlantController::class, 'index']);
Route::get('/test3', [App\Http\Controllers\Tests\ImagesPlantController::class, 'index']);
Route::get('/test4', [App\Http\Controllers\Tests\TestsController::class, 'index']);
