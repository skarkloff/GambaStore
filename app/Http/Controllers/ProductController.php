<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Cloudinary\Cloudinary;


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
            'nombre'      => 'required',
            'marca'       => 'required',
            'modelo'      => 'required',
            'precio'      => 'required|numeric',
            'stock'       => 'required|integer',
            'talles'      => 'nullable|string',
            'imagen'      => 'required|image|max:2048',
            'descripcion' => 'nullable',
        ]);

        // CONFIGURACIÓN MANUAL DIRECTA (Saltamos el ServiceProvider)
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
        ]);

        // SUBIDA USANDO EL SDK DIRECTO
        $file = $request->file('imagen');
        $upload = $cloudinary->uploadApi()->upload($file->getRealPath(), [
            'folder' => 'gamba-store'
        ]);

        // Guardamos la URL que nos devuelve el array de Cloudinary
        $data['imagen_url'] = $upload['secure_url'];

        if (!empty($data['talles'])) {
            $data['talles'] = array_map('trim', explode(',', $data['talles']));
        }

        \App\Models\Product::create($data);

        return redirect()->route('products.index');
    }

    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'talles' => 'nullable',
            'imagen' => 'nullable|image|max:2048',
            'descripcion' => 'nullable',
        ]);

        if ($request->hasFile('imagen')) {
            // !!! IMPORTANTE: Agregamos la configuración también acá !!!
            config([
                'cloudinary.cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'cloudinary.api_key'    => env('CLOUDINARY_API_KEY'),
                'cloudinary.api_secret' => env('CLOUDINARY_API_SECRET'),
            ]);

            $uploadedFileUrl = Cloudinary::upload($request->file('imagen')->getRealPath(), [
                'folder' => 'gamba-store'
            ])->getSecurePath();
            
            $data['imagen_url'] = $uploadedFileUrl;
        } else {
            $data['imagen_url'] = $product->imagen_url;
        }

        if (isset($data['talles']) && is_string($data['talles'])) {
            $data['talles'] = array_map('trim', explode(',', $data['talles']));
        }

        $product->update($data);
        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        // 1. Buscamos el producto en MongoDB
        $product = \App\Models\Product::findOrFail($id);

        // 2. Lo eliminamos
        $product->delete();

        // 3. Redirigimos con un mensaje de éxito
        return redirect()->route('products.index')->with('success', 'Botín eliminado correctamente');
    }
}