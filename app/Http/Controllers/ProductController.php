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

        if (!empty($data['talles'])) {
            $data['talles'] = array_map('trim', explode(',', $data['talles']));
        }

        Product::create($data);

        return redirect()->route('products.index');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'nombre'      => 'required',
            'marca'       => 'required',
            'modelo'      => 'required',
            'precio'      => 'required|numeric',
            'stock'       => 'required|integer',
            'talles'      => 'nullable',
            'imagen'      => 'nullable|image|max:2048',
            'descripcion' => 'nullable',
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

        if (isset($data['talles']) && is_string($data['talles'])) {
            $data['talles'] = array_map('trim', explode(',', $data['talles']));
        }

        $product->update($data);
        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Botín eliminado correctamente');
    }
}
