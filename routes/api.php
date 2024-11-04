<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\BosController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

 
Route::get('/user', [PenggunaController::class, 'index']);
Route::post('/list', [PenggunaController::class, 'listpengguna']);
Route::get('/bos/history', [PenggunaController::class, 'history']);
Route::put('/bos/stor', [BosController::class, 'store']);
Route::put('/bos/transfer', [BosController::class, 'transfer']);
Route::put('/bos/tarik', [BosController::class, 'tarik']);
Route::put('/bos/transaction/{note}', [BosController::class, 'processing']);