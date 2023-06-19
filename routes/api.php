<?php

use App\Http\Controllers\FacturaController;
use App\Http\Controllers\FacturaProductoController;
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

Route::get('getFacturas', [FacturaController::class, 'getAll']);
Route::post('getFacturaDetail', [FacturaProductoController::class, 'getFacturaDetail']);
Route::post('deleteFacturaDetail', [FacturaProductoController::class, 'deleteFacturaDetail']);

Route::get('getNecessaryDataToCreate', [FacturaController::class, 'getNecessaryDataToCreate']);
Route::post('createFactura', [FacturaController::class, 'store']);
