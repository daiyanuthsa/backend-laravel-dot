<?php

use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

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
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user/delete', [AuthController::class, 'deleteUser']);

    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::post('create', [CategoryController::class, 'store']);
        Route::put('edit/{id}', [CategoryController::class, 'update']);
        Route::delete('delete/{id}', [CategoryController::class, 'delete']);
    });

    Route::prefix('book')->group(function () {
        Route::get('/', [BookController::class, 'index']);
        Route::post('create', [BookController::class, 'store']);
        Route::put('edit/{id}', [BookController::class, 'update']);
        Route::delete('delete/{id}', [BookController::class, 'destroy']);
    });

});
