<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodoPago;

class MetodoPagoController extends Controller
{
    public function index()
    {
        $metodos = MetodoPago::all();
        return view('admin.metodos_pago.index', compact('metodos'));
    }

    public function create()
    {
        return view('admin.metodos_pago.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:100',
        ]);

        $data['activo'] = $request->has('activo');

        MetodoPago::create($data);

        return redirect()->route('metodos_pago.index')->with('success', 'Método de pago creado correctamente.');
    }

    public function edit(string $id)
    {
        $metodo = MetodoPago::findOrFail($id);
        return view('admin.metodos_pago.edit', compact('metodo'));
    }

    public function update(Request $request, string $id)
    {
        $metodo = MetodoPago::findOrFail($id);

        $data = $request->validate([
            'descripcion' => 'required|string|max:100',
        ]);

        $data['activo'] = $request->has('activo');

        $metodo->update($data);

        return redirect()->route('metodos_pago.index')->with('success', 'Método de pago actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $metodo = MetodoPago::findOrFail($id);
        $metodo->delete();
        return redirect()->route('metodos_pago.index')->with('success', 'Método de pago eliminado correctamente.');
    }
}
