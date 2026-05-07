<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'talles' => 'nullable',
            'imagen_url' => 'nullable|url',
            'descripcion' => 'nullable',
        ]);

        \App\Models\Product::create($data);

        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index');
    }

    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nombre' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'talles' => 'nullable',
            'imagen_url' => 'nullable|url',
            'descripcion' => 'nullable',
        ]);

        if (isset($data['talles']) && is_string($data['talles'])) {
            // Convierte la cadena de talles en un array, eliminando espacios
            $data['talles'] = array_map('trim', explode(',', $data['talles']));
        }

        $product = \App\Models\Product::findOrFail($id);
        $product->update($data);

        return redirect()->route('products.index');
    }
}