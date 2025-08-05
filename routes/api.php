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
use App\Http\Controllers\Api\LogApiController;

// o que "throttle:60,1" faz: limita o número de requisições a 60 requests por minuto pra cada IP/token, passando o limite, é retornado http response 429 Too many attemps.
Route::middleware('api.token', 'throttle:60,1')->group(function () {
    Route::get('/logs', [LogApiController::class, 'index']);
    Route::get('/logs/{id}', [LogApiController::class, 'show']);
    Route::post('/logs', [LogApiController::class, 'store']);
    Route::get('/logs/export', [LogApiController::class, 'export']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
