<?php

use App\Http\Controllers\V1\AdminController;
use App\Http\Controllers\V1\CargaUsuariosController;
use App\Http\Controllers\V1\CategoriaController;
use App\Http\Controllers\V1\ApoyoController;
use App\Http\Controllers\V1\CategoriaTKController;
use App\Http\Controllers\V1\ComentarioController;
use App\Http\Controllers\V1\ItemController;
use App\Http\Controllers\V1\PermisoUsuarioController;
use App\Http\Controllers\V1\QuejaController;
use App\Http\Controllers\V1\TarjetaController;
use App\Http\Controllers\V1\TicketController;
use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\FileController;
use App\Models\CategoriaTK;
use App\Models\PermisosUsuario;
use App\Models\Ticket;
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

Route::post('v1/carga_usuarios', [CargaUsuariosController::class, 'cargarDatos'])
        ->middleware('auth:sanctum');

Route::apiResource('v1/PermisosUsuarios', PermisoUsuarioController::class)
        ->only('destroy');

Route::apiResource('v1/tarjetas', TarjetaController::class)
        ->only('index', 'show', 'store', 'update', 'destroy');

Route::apiResource('v1/categorias', CategoriaController::class)
        ->only('index', 'store', 'update', 'destroy');

Route::apiResource('v1/noticias', NoticiaController::class) //cantidad de likes y fecha
        ->only('index', 'store', 'show', 'update', 'destroy');

Route::apiResource('v1/apoyo', ApoyoController::class)
        ->only('store', 'index');

Route::post('v1/noticias/cantidadNoticias', [NoticiaController::class, 'cantidadNoticias']);

Route::apiResource('v1/tipo_usuario', TipoUsuarioController::class)
        ->only('show');

Route::apiResource('v1/tickets', TicketController::class)
        ->only('index', 'store', 'show');

Route::apiResource('v1/tickets', TicketController::class)
        ->only('update', 'destroy')
        ->middleware('auth:sanctum');

Route::apiResource('v1/categoriasTK', CategoriaTKController::class)
        ->only('index', 'show');

Route::apiResource('v1/categoriasTK', CategoriaTKController::class)
        ->only('update', 'store', 'destroy')
        ->middleware('auth:sanctum');

Route::apiResource('v1/items', ItemController::class)
        ->only('index', 'show');

Route::apiResource('v1/items', ItemController::class)
        ->only('update', 'store', 'destroy')
        ->middleware('auth:sanctum');
        
Route::apiResource('v1/comentarios', ComentarioController::class)
        ->only('show');

Route::apiResource('v1/quejas', QuejaController::class)
        ->only('index', 'store', 'update');

Route::apiResource('v1/users', UserController::class)
        ->only('index', 'show', 'store', 'update', 'destroy')
        ->middleware('auth:sanctum');
        
Route::apiResource('v1/administradors', AdminController::class)
        ->only('show')
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