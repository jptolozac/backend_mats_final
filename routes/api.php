<?php

use App\Http\Controllers\V1\ApoyoController;
use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\FileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\NoticiaController;
use App\Http\Controllers\V1\TipoUsuarioController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
/* 
Route::apiResource('v1/noticias/generales', NoticiaController::class) //publico por fecha
        ->only('index','show');

Route::apiResource('v1/noticias/ud', NoticiaController::class) //fecha
        ->only('index','show');

Route::apiResource('v1/noticias/interes', NoticiaController::class) //cantidad de likes y fecha
        ->only('index','show');
 */

Route::apiResource('v1/noticias', NoticiaController::class) //cantidad de likes y fecha
        ->only('index','show', 'update');

Route::apiResource('v1/apoyo', ApoyoController::class)
        ->only('store', 'index'); //rubio puto
//algo

Route::post('v1/noticias', [NoticiaController::class, 'cantidadNoticias']);

Route::apiResource('v1/tipo_usuario', TipoUsuarioController::class)
        ->only('show');

Route::apiResource('v1/users', UserController::class)
        ->only('index')
        ->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('v1/archivo/{id}', [FileController::class, 'storeFile']); //continuar
Route::get('v1/archivo/{id}', [FileController::class, 'downloadFile']);

Route::post('login', [App\Http\Controllers\LoginController::class, 'login']);

Route::get('login', function(){
        return response()->json([
                "Mensaje" => "Token invalido"
        ]);
});