<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('subscription-users',\App\Http\Controllers\SubscriptionUserController::class);
Route::resource('post',\App\Http\Controllers\PostController::class);
Route::resource('subscription',\App\Http\Controllers\SubscriptionController::class);
Route::resource('website',\App\Http\Controllers\WebsiteController::class);
Route::post('subscription/create',[\App\Http\Controllers\SubscriptionController::class,'createSubscription']);
Route::post('subscription/remove',[\App\Http\Controllers\SubscriptionController::class,'removeSubscription']);
