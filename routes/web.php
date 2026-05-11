<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/debug-firestore', function () {
    $raw  = env('FIREBASE_CREDENTIALS', '');
    $creds = json_decode($raw, true);
    return response()->json([
        'raw_length'    => strlen($raw),
        'json_error'    => json_last_error_msg(),
        'project_id'    => env('FIREBASE_PROJECT_ID'),
        'creds_keys'    => $creds ? array_keys($creds) : null,
        'has_key'       => isset($creds['private_key']),
        'key_start'     => isset($creds['private_key']) ? substr($creds['private_key'], 0, 30) : null,
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