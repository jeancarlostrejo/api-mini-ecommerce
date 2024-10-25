<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/me', [AuthController::class, 'me']);

    //Crud brand
    Route::apiResource('brands', BrandController::class)->middleware('auth:api');

    //Crud categories
    Route::apiResource('categories', CategoryController::class)->middleware('auth:api');

    //Crud locations
    Route::get('/locations', [LocationController::class, 'index'])->middleware('auth:api');
    Route::post('/locations', [LocationController::class, 'store'])->middleware('auth:api');
    Route::put('/locations/{location}', [LocationController::class, 'update'])->middleware('auth:api');
    Route::delete('/locations/{location}', [LocationController::class, 'destroy'])->middleware('auth:api');

    //Crud products
    Route::apiResource('products', ProductController::class)->middleware('auth:api');

    //Orders
    Route::post('/orders', [OrderController::class, 'store'])->middleware('auth:api');
    Route::get('/orders', [OrderController::class, 'index'])->middleware('auth:api');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->middleware('auth:api');
});

