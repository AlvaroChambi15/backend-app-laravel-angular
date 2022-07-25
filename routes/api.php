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

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\NuevoPasswordController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("v1/auth")->group(function () {

    Route::post('/login', [AuthController::class, "login"]);
    Route::post('/registro', [AuthController::class, "registro"]);

    Route::middleware("auth:sanctum")->group(function () {

        Route::post('/logout', [AuthController::class, "logout"]);
        Route::get('/perfil', [AuthController::class, "perfil"]);
    });
});

Route::middleware("auth:sanctum")->group(function () {

    Route::post('/producto/{id}/actualizar-imagen', [ProductoController::class, "actualizarImagen"]);

    Route::apiResource("categoria", CategoriaController::class);
    Route::apiResource("producto", ProductoController::class);
    Route::apiResource("cliente", ClienteController::class);
    Route::apiResource("pedido", PedidoController::class);
});

Route::get("/pdf", [PedidoController::class, "reportePedidos"]);


Route::post("recuperar-password",  [NuevoPasswordController::class, "recuperarPassword"]);

Route::post("reset-password",  [NuevoPasswordController::class, "reset"]);


Route::get("/no_autorizado", function () {
    return response()->json(["mensaje" => "NO ESTAS AUTORIZADO PARA VER ESTA PAGINA!"]);
})->name("login");