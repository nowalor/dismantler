<?php

use App\Models\DitoNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GetUniqueManufacturerPlaintextController;

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

Route::get('api-test', \App\Http\Controllers\ApiTestController::class);

Route::get('car-brands', function() {
    $brands = DitoNumber::distinct('producer')->pluck('producer');

    return $brands;
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('plaintexts', GetUniqueManufacturerPlaintextController::class);
Route::get('', function() {
    return 'Welcome to API';
});


