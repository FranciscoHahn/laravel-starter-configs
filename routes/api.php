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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ejemplo', function () {
    return response()->json(['mensaje' => '¡Hola, mundo!']);
});

Route::post('/autenticar', 'App\Http\Controllers\Autenticacion@autenticar')->name('autenticar');
Route::get('/hola', 'App\Http\Controllers\Algo@hola')->name('hola')->middleware('verificarToken:ALL');

Route::group(['middleware' => 'verificarToken:ADM'], function () {
    Route::get('/solo_admin', 'App\Http\Controllers\Algo@solo_admin')->name('solo_admin');
    Route::get('/esto_tambien_es_solo_para_admin', 'App\Http\Controllers\Algo@esto_tambien_es_solo_para_admin')->name('esto_tambien_es_solo_para_admin');
});

Route::get('/solo_vista', 'App\Http\Controllers\Algo@solo_vista')
    ->name('solo_vista')
    ->middleware('verificarToken:VIEW');

Route::get('/todos_pueden_acceder', 'App\Http\Controllers\Algo@todos_pueden_acceder')
    ->name('todos_pueden_acceder')
    ->middleware('verificarToken:ALL');
