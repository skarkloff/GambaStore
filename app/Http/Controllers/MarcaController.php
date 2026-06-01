<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;

class MarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::all();
        return view('admin.marcas.index', compact('marcas'));
    }

    public function create()
    {
        return view('admin.marcas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:100',
        ]);

        Marca::create($data);

        return redirect()->route('marcas.index')->with('success', 'Marca creada correctamente');
    }

    public function edit($id)
    {
        $marca = Marca::findOrFail($id);
        return view('admin.marcas.edit', compact('marca'));
    }

    public function update(Request $request, $id)
    {
        $marca = Marca::findOrFail($id);

        $data = $request->validate([
            'descripcion' => 'required|string|max:100',
        ]);

        $marca->update($data);

        return redirect()->route('marcas.index')->with('success', 'Marca actualizada correctamente');
    }

    public function destroy($id)
    {
        $marca = Marca::findOrFail($id);
        $marca->delete();
        return redirect()->route('marcas.index')->with('success', 'Marca eliminada correctamente');
    }
}
