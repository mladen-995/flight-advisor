<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CheapestFlightController;
use App\Http\Controllers\UserController;
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

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('cities', [CityController::class, 'index']);
    Route::post('cities', [CityController::class, 'store'])->middleware('admin');

    Route::post('comments', [CommentController::class, 'store']);
    Route::put('comments/{comment}', [CommentController::class, 'update']);
    Route::delete('comments/{comment}', [CommentController::class, 'delete']);

    Route::post('/find-cheapest-flight', [CheapestFlightController::class, 'findFlight']);
});

