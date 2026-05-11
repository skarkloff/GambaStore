<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/debug-ext', function () {
    return response()->json([
        'mongodb_loaded' => extension_loaded('mongodb'),
        'php_version'    => PHP_VERSION,
        'extensions'     => get_loaded_extensions(),
    ]);
});


// 1. La ruta para VER el listado 
Route::get('/admin/productos', [ProductController::class, 'index'])->name('products.index');

// 2. La ruta para mostrar el FORMULARIO 
Route::get('/admin/productos/nuevo', [ProductController::class, 'create'])->name('products.create');

// 3. La ruta para GUARDAR los datos del formulario
Route::post('/admin/productos/guardar', [ProductController::class, 'store'])->name('products.store');

// 4. La ruta para ELIMINAR un producto
Route::delete('/admin/productos/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

// 5. Rutas para editar productos (opcional, pero recomendado para una gestión completa)
Route::get('/admin/productos/{id}/editar', [ProductController::class, 'edit'])->name('products.edit');

// 6. Ruta para actualizar el producto después de editar
Route::put('/admin/productos/{id}', [ProductController::class, 'update'])->name('products.update');