<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\MarcaController;
use App\Http\Controllers\Api\PromocionController;
use App\Http\Controllers\Api\MetodoPagoController;
use App\Http\Controllers\Api\PedidoController;

// ── PÚBLICOS ──────────────────────────────────────
Route::get('/productos',                    [ProductoController::class,  'index']);
Route::get('/productos/{id}',               [ProductoController::class,  'show']);
Route::get('/marcas',                       [MarcaController::class,     'index']);
Route::get('/metodos-pago',                 [MetodoPagoController::class,'index']);
Route::get('/promociones/activas',          [PromocionController::class, 'activas']);
Route::post('/promociones/validar-codigo',  [PromocionController::class, 'validarCodigo']);

// ── PROTEGIDOS (requieren Google ID Token) ────────
Route::middleware('auth.google')->group(function () {
    Route::get('/pedidos',       [PedidoController::class, 'index']);
    Route::get('/pedidos/{id}',  [PedidoController::class, 'show']);
    Route::post('/pedidos',      [PedidoController::class, 'store']);
});
