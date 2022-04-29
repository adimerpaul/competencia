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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('login',[\App\Http\Controllers\UserController::class,'login']);
Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::post('logout',[\App\Http\Controllers\UserController::class,'logout']);
    Route::post('me',[\App\Http\Controllers\UserController::class,'me']);
    Route::post('consulta',[\App\Http\Controllers\RegistroController::class,'consulta']);
    Route::resource('player',\App\Http\Controllers\PlayerController::class);
    Route::resource('evento',\App\Http\Controllers\EventoController::class);
    Route::resource('registro',\App\Http\Controllers\RegistroController::class);
    Route::resource('history',\App\Http\Controllers\HistoryController::class);
});
