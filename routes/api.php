<?php

use App\Http\Controllers\OrderController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/orders/{id}', [OrderController::class, 'getOrder']);
Route::get('/orders', [OrderController::class, 'getUserOrders']);
Route::post('/orders', [OrderController::class, 'createOrder']);
Route::put('/orders/{id}', [OrderController::class, 'updateOrder']);
