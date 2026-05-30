<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

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
