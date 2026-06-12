<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Resources\PedidoResource;
use App\Models\Pedido;

class PedidoController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $uid     = $request->auth_uid;
        $todos   = Pedido::all();
        $propios = array_filter($todos, fn($p) => $p->cliente_id === $uid);

        return PedidoResource::collection(collect(array_values($propios)));
    }

    public function show(\Illuminate\Http\Request $request, string $id)
    {
        $pedido = Pedido::findOrFail($id);

        if ($pedido->cliente_id !== $request->auth_uid) {
            return response()->json(['error' => 'No autorizado.'], 403);
        }

        return new PedidoResource($pedido);
    }

    public function store(StorePedidoRequest $request)
    {
        $data     = $request->validated();
        $subtotal = array_sum(array_map(
            fn($i) => $i['precio_unitario'] * $i['cantidad'],
            $data['items']
        ));

        $payload = [
            'cliente_id'       => $request->auth_uid,
            'cliente_nombre'   => $request->auth_name,
            'cliente_email'    => $request->auth_email,
            'estado'           => 'pendiente',
            'fecha'            => now()->toIso8601String(),
            'items'            => $data['items'],
            'subtotal'         => round($subtotal, 2),
            'descuento'        => 0.0,
            'total'            => round($subtotal, 2),
            'promocion_codigo' => $data['promocion_codigo'] ?? '',
            'metodo_pago_id'   => $data['metodo_pago_id'],
            'direccion'        => $data['direccion'],
            'numero_tracking'  => '',
            'notas'            => $data['notas'] ?? '',
        ];

        $pedido = Pedido::create($payload);

        return (new PedidoResource($pedido))
            ->response()
            ->setStatusCode(201);
    }
}
