<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\v1\InvoiceController;
use App\Http\Controllers\Api\v1\OrderController;
use App\Http\Controllers\Api\v1\RestaurantController;
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

## BOC : use {version} to support multiple version api
Route::prefix("{version}")->group(function() {
    Route::post('login',[LoginController::class,'login']);
    
    Route::middleware('auth:sanctum')->group(function() {
        Route::prefix('restaurants')->group(function(){
            Route::get('',[RestaurantController::class,'getListOfRestaurant']);
            Route::get('{id}',[RestaurantController::class,'getRestaurant']);
            Route::prefix('menus')->group(function() {
                Route::get('{id}',[RestaurantController::class,'getListOfRestaurantMenus']);
            });
            Route::prefix('orders')->group(function() {
                Route::post('{id}',[OrderController::class,'store']);
            });  
        });
        Route::prefix('invoices')->group(function() {
            Route::prefix('pay')->group(function() {
                Route::post('{id}',[InvoiceController::class,'payInvoice']);
            });
        });
    });
});

## EOC
