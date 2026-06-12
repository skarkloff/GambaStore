<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promocion;
use App\Models\Marca;
use App\Models\Product;

class PromocionController extends Controller
{
    public function index()
    {
        $promociones = Promocion::all();
        $marcas      = Marca::allAsMap();
        return view('admin.promociones.index', compact('promociones', 'marcas'));
    }

    public function create()
    {
        $marcas    = Marca::all();
        $productos = Product::all();
        return view('admin.promociones.create', compact('marcas', 'productos'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'valor'         => str_replace(',', '.', $request->input('valor') ?? ''),
            'minimo_compra' => str_replace(',', '.', $request->input('minimo_compra') ?? ''),
        ]);

        $data = $request->validate([
            'nombre'        => 'required|string|max:100',
            'tipo'          => 'required|in:porcentaje,monto_fijo',
            'valor'         => 'required|numeric|gt:0',
            'codigo'        => 'nullable|string|max:50',
            'fecha_inicio'  => 'required|date',
            'fecha_fin'     => 'required|date|after_or_equal:fecha_inicio',
            'minimo_compra' => 'nullable|numeric|min:0',
            'aplica_a'      => 'required|in:todo,marca,tipo,producto',
            'marca_id'      => 'required_if:aplica_a,marca|nullable|string',
            'tipo_producto' => 'required_if:aplica_a,tipo|nullable|in:' . implode(',', Product::TIPOS),
            'producto_id'   => 'required_if:aplica_a,producto|nullable|string',
        ]);

        $payload = [
            'nombre'        => $data['nombre'],
            'tipo'          => $data['tipo'],
            'valor'         => (float) $data['valor'],
            'codigo'        => $data['codigo'] ?? '',
            'fecha_inicio'  => $data['fecha_inicio'],
            'fecha_fin'     => $data['fecha_fin'],
            'minimo_compra' => isset($data['minimo_compra']) && $data['minimo_compra'] !== '' ? (float) $data['minimo_compra'] : null,
            'aplica_a'      => $data['aplica_a'],
            'marca_id'       => $data['aplica_a'] === 'marca'    ? ($data['marca_id'] ?? '')       : '',
            'tipo_producto'  => $data['aplica_a'] === 'tipo'     ? ($data['tipo_producto'] ?? '')  : '',
            'producto_id'    => $data['aplica_a'] === 'producto' ? ($data['producto_id'] ?? '')    : '',
            'activa'         => $request->has('activa'),
        ];

        Promocion::create($payload);

        return redirect()->route('promociones.index')->with('success', 'Promoción creada correctamente.');
    }

    public function edit(string $id)
    {
        $promocion = Promocion::findOrFail($id);
        $marcas    = Marca::all();
        $productos = Product::all();
        return view('admin.promociones.edit', compact('promocion', 'marcas', 'productos'));
    }

    public function update(Request $request, string $id)
    {
        $promocion = Promocion::findOrFail($id);

        $request->merge([
            'valor'         => str_replace(',', '.', $request->input('valor') ?? ''),
            'minimo_compra' => str_replace(',', '.', $request->input('minimo_compra') ?? ''),
        ]);

        $data = $request->validate([
            'nombre'        => 'required|string|max:100',
            'tipo'          => 'required|in:porcentaje,monto_fijo',
            'valor'         => 'required|numeric|gt:0',
            'codigo'        => 'nullable|string|max:50',
            'fecha_inicio'  => 'required|date',
            'fecha_fin'     => 'required|date|after_or_equal:fecha_inicio',
            'minimo_compra' => 'nullable|numeric|min:0',
            'aplica_a'      => 'required|in:todo,marca,tipo,producto',
            'marca_id'      => 'required_if:aplica_a,marca|nullable|string',
            'tipo_producto' => 'required_if:aplica_a,tipo|nullable|in:' . implode(',', Product::TIPOS),
            'producto_id'   => 'required_if:aplica_a,producto|nullable|string',
        ]);

        $payload = [
            'nombre'        => $data['nombre'],
            'tipo'          => $data['tipo'],
            'valor'         => (float) $data['valor'],
            'codigo'        => $data['codigo'] ?? '',
            'fecha_inicio'  => $data['fecha_inicio'],
            'fecha_fin'     => $data['fecha_fin'],
            'minimo_compra' => isset($data['minimo_compra']) && $data['minimo_compra'] !== '' ? (float) $data['minimo_compra'] : null,
            'aplica_a'      => $data['aplica_a'],
            'marca_id'       => $data['aplica_a'] === 'marca'    ? ($data['marca_id'] ?? '')       : '',
            'tipo_producto'  => $data['aplica_a'] === 'tipo'     ? ($data['tipo_producto'] ?? '')  : '',
            'producto_id'    => $data['aplica_a'] === 'producto' ? ($data['producto_id'] ?? '')    : '',
            'activa'         => $request->has('activa'),
        ];

        $promocion->update($payload);

        return redirect()->route('promociones.index')->with('success', 'Promoción actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $promocion = Promocion::findOrFail($id);
        $promocion->delete();
        return redirect()->route('promociones.index')->with('success', 'Promoción eliminada correctamente.');
    }
}
