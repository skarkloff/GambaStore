<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PromocionController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==========================================
// RUTAS PROTEGIDAS (requieren sesión)
// ==========================================
Route::middleware('admin.auth')->group(function () {

    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/perfil', [LoginController::class, 'profile'])->name('admin.profile');

    // ── PRODUCTOS ──────────────────────────
    Route::get('/admin/productos', [ProductController::class, 'index'])->name('products.index');
    Route::get('/admin/productos/nuevo', [ProductController::class, 'create'])->name('products.create');
    Route::post('/admin/productos/guardar', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/admin/productos/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/admin/productos/{id}/editar', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/admin/productos/{id}', [ProductController::class, 'update'])->name('products.update');

    // ── MARCAS ────────────────────────────
    Route::get('/admin/marcas', [MarcaController::class, 'index'])->name('marcas.index');
    Route::get('/admin/marcas/nueva', [MarcaController::class, 'create'])->name('marcas.create');
    Route::post('/admin/marcas/guardar', [MarcaController::class, 'store'])->name('marcas.store');
    Route::get('/admin/marcas/{id}/editar', [MarcaController::class, 'edit'])->name('marcas.edit');
    Route::put('/admin/marcas/{id}', [MarcaController::class, 'update'])->name('marcas.update');
    Route::delete('/admin/marcas/{id}', [MarcaController::class, 'destroy'])->name('marcas.destroy');

    // ── PROMOCIONES ───────────────────────
    Route::get('/admin/promociones', [PromocionController::class, 'index'])->name('promociones.index');
    Route::get('/admin/promociones/nueva', [PromocionController::class, 'create'])->name('promociones.create');
    Route::post('/admin/promociones/guardar', [PromocionController::class, 'store'])->name('promociones.store');
    Route::get('/admin/promociones/{id}/editar', [PromocionController::class, 'edit'])->name('promociones.edit');
    Route::put('/admin/promociones/{id}', [PromocionController::class, 'update'])->name('promociones.update');
    Route::delete('/admin/promociones/{id}', [PromocionController::class, 'destroy'])->name('promociones.destroy');

    // ── USUARIOS (solo Administrador) ──────
    Route::middleware('admin.role')->group(function () {
        Route::get('/admin/usuarios', [UserController::class, 'index'])->name('users.index');
        Route::get('/admin/usuarios/nuevo', [UserController::class, 'create'])->name('users.create');
        Route::post('/admin/usuarios/guardar', [UserController::class, 'store'])->name('users.store');
        Route::get('/admin/usuarios/{id}/editar', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/admin/usuarios/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/admin/usuarios/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});
