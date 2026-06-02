<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Marca;
use Cloudinary\Cloudinary;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $marcas   = Marca::allAsMap();
        return view('admin.products.index', compact('products', 'marcas'));
    }

    public function create()
    {
        $marcas = Marca::all();
        return view('admin.products.create', compact('marcas'));
    }

    public function store(Request $request)
    {
        $request->merge(['precio' => str_replace(',', '.', $request->input('precio', ''))]);

        $data = $request->validate([
            'nombre'          => 'required',
            'marca_id'        => 'required|string',
            'modelo'          => 'required',
            'tipo'            => 'required|in:' . implode(',', \App\Models\Product::TIPOS),
            'precio'          => 'required|numeric|gt:0',
            'talles'          => 'nullable|array',
            'talles.*.talle'  => 'required|string',
            'talles.*.stock'  => 'required|integer|min:1',
            'imagen'          => 'required|image|max:2048',
            'descripcion'     => 'nullable',
        ]);

        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
        ]);

        $upload = $cloudinary->uploadApi()->upload($request->file('imagen')->getRealPath(), [
            'folder' => 'gamba-store',
        ]);

        $data['imagen_url'] = $upload['secure_url'];
        unset($data['imagen']);

        $data['precio'] = (float) $data['precio'];

        $data['talles'] = array_values(array_map(
            fn($t) => ['talle' => trim($t['talle']), 'stock' => (int) $t['stock']],
            $data['talles'] ?? []
        ));

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Botín creado correctamente');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $marcas  = Marca::all();
        return view('admin.products.edit', compact('product', 'marcas'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->merge(['precio' => str_replace(',', '.', $request->input('precio', ''))]);

        $data = $request->validate([
            'nombre'          => 'required',
            'marca_id'        => 'required|string',
            'modelo'          => 'required',
            'tipo'            => 'required|in:' . implode(',', \App\Models\Product::TIPOS),
            'precio'          => 'required|numeric|gt:0',
            'talles'          => 'nullable|array',
            'talles.*.talle'  => 'required|string',
            'talles.*.stock'  => 'required|integer|min:1',
            'imagen'          => 'nullable|image|max:2048',
            'descripcion'     => 'nullable',
        ]);

        if ($request->hasFile('imagen')) {
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key'    => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
            ]);

            $upload = $cloudinary->uploadApi()->upload($request->file('imagen')->getRealPath(), [
                'folder' => 'gamba-store',
            ]);

            $data['imagen_url'] = $upload['secure_url'];
        } else {
            $data['imagen_url'] = $product->imagen_url;
        }

        unset($data['imagen']);

        $data['precio'] = (float) $data['precio'];

        $data['talles'] = array_values(array_map(
            fn($t) => ['talle' => trim($t['talle']), 'stock' => (int) $t['stock']],
            $data['talles'] ?? []
        ));

        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Botín actualizado correctamente');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Botín eliminado correctamente');
    }
}
