<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController; // Importamos el controlador de usuarios arriba

Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// PANTALLA INTERMEDIA (DASHBOARD CENTRAL)
// ==========================================
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');


// ==========================================
// RUTAS DE PRODUCTOS
// ==========================================
// 1. La ruta para VER el listado 
Route::get('/admin/productos', [ProductController::class, 'index'])->name('products.index');

// 2. La ruta para mostrar el FORMULARIO 
Route::get('/admin/productos/nuevo', [ProductController::class, 'create'])->name('products.create');

// 3. La ruta para GUARDAR los datos del formulario
Route::post('/admin/productos/guardar', [ProductController::class, 'store'])->name('products.store');

// 4. La ruta para ELIMINAR un producto
Route::delete('/admin/productos/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

// 5. Rutas para editar productos
Route::get('/admin/productos/{id}/editar', [ProductController::class, 'edit'])->name('products.edit');

// 6. Ruta para actualizar el producto después de editar
Route::put('/admin/productos/{id}', [ProductController::class, 'update'])->name('products.update');


// ==========================================
// RUTAS DE USUARIOS (Hechas a espejo de productos)
// ==========================================
// 1. La ruta para VER el listado
Route::get('/admin/usuarios', [UserController::class, 'index'])->name('users.index');

// 2. La ruta para mostrar el FORMULARIO
Route::get('/admin/usuarios/nuevo', [UserController::class, 'create'])->name('users.create');

// 3. La ruta para GUARDAR los datos del formulario
Route::post('/admin/usuarios/guardar', [UserController::class, 'store'])->name('users.store');

// 4. Rutas para editar usuarios
Route::get('/admin/usuarios/{id}/editar', [UserController::class, 'edit'])->name('users.edit');

// 5. Ruta para actualizar el usuario después de editar
Route::put('/admin/usuarios/{id}', [UserController::class, 'update'])->name('users.update');

// 6. La ruta para ELIMINAR un usuario
Route::delete('/admin/usuarios/{id}', [UserController::class, 'destroy'])->name('users.destroy');