<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductoResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $productos = Product::all();

        if ($request->query('marca_id')) {
            $productos = array_filter($productos, fn($p) => $p->marca_id === $request->query('marca_id'));
        }

        if ($request->query('tipo')) {
            $productos = array_filter($productos, fn($p) => $p->tipo === $request->query('tipo'));
        }

        return ProductoResource::collection(collect(array_values($productos)));
    }

    public function show(string $id)
    {
        $producto = Product::findOrFail($id);
        return new ProductoResource($producto);
    }
}
