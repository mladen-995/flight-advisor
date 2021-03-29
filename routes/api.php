<?php

use App\Http\Controllers\CityController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('cities', [CityController::class, 'index']);
Route::post('cities', [CityController::class, 'store']);

Route::post('comments/create', [CityController::class, 'store']);
Route::put('comments/{comment}', [CityController::class, 'update']);
Route::delete('comments/{comment}', [CityController::class, 'delete']);
