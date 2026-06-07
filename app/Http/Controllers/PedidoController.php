<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\MetodoPago;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $estado    = $request->query('estado');
        $pedidos   = Pedido::all($estado ?: null);
        $metodos   = MetodoPago::allAsMap();
        return view('admin.pedidos.index', compact('pedidos', 'metodos', 'estado'));
    }

    public function show(string $id)
    {
        $pedido  = Pedido::findOrFail($id);
        $metodos = MetodoPago::allAsMap();
        return view('admin.pedidos.show', compact('pedido', 'metodos'));
    }

    public function edit(string $id)
    {
        $pedido = Pedido::findOrFail($id);
        return view('admin.pedidos.edit', compact('pedido'));
    }

    public function update(Request $request, string $id)
    {
        $pedido = Pedido::findOrFail($id);

        $data = $request->validate([
            'estado'           => 'required|in:' . implode(',', Pedido::ESTADOS),
            'numero_tracking'  => 'nullable|string|max:100',
        ]);

        $pedido->update([
            'estado'          => $data['estado'],
            'numero_tracking' => $data['numero_tracking'] ?? '',
        ]);

        return redirect()->route('pedidos.show', $id)->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado correctamente.');
    }
}
