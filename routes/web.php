<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/debug-firestore', function () {
    try {
        $tmpFile = sys_get_temp_dir() . '/firebase_credentials.json';
        file_put_contents($tmpFile, env('FIREBASE_CREDENTIALS', '{}'));
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $tmpFile);

        $db = new \Google\Cloud\Firestore\FirestoreClient([
            'projectId' => env('FIREBASE_PROJECT_ID'),
        ]);

        $count = 0;
        foreach ($db->collection('products')->documents() as $d) { $count++; }

        return response()->json(['ok' => true, 'docs' => $count]);
    } catch (\Throwable $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'class' => get_class($e),
            'file'  => basename($e->getFile()) . ':' . $e->getLine(),
        ]);
    }
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