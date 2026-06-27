<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Resources\PedidoResource;
use App\Models\Pedido;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

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

        $clienteId     = !empty($request->auth_uid) ? $request->auth_uid : 'invitado';
        $clienteNombre = !empty($request->auth_name) ? $request->auth_name : 'Cliente Invitado';
        $clienteEmail  = !empty($request->auth_email) ? $request->auth_email : 'invitado@gambastore.com';

        $payload = [
            'cliente_id'       => $clienteId,
            'cliente_nombre'   => $clienteNombre,
            'cliente_email'    => $clienteEmail,
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

        $mpAccessToken = env('MERCADOPAGO_ACCESS_TOKEN');

        $mpItems = array_map(function ($item) {
            try {
                $product = Product::findOrFail($item['producto_id']);
                $title   = $product->nombre . " (Talle: " . $item['talle'] . ")";
            } catch (\Exception $e) {
                $title   = "Producto " . $item['producto_id'] . " (Talle: " . $item['talle'] . ")";
            }

            return [
                'id'          => $item['producto_id'],
                'title'       => $title,
                'quantity'    => (int) $item['cantidad'],
                'unit_price'  => (float) $item['precio_unitario'],
                'currency_id' => 'ARS',
            ];
        }, $data['items']);

        $response = Http::withToken($mpAccessToken)
            ->post('https://api.mercadopago.com/checkout/preferences', [
                'items'     => $mpItems,
                'back_urls' => [
                    'success' => 'https://gambastore-frontend.vercel.app/exito',
                    'failure' => 'https://gambastore-frontend.vercel.app/checkout',
                    'pending' => 'https://gambastore-frontend.vercel.app/checkout'
                ],
                'auto_return' => 'approved',
                'external_reference' => $pedido->id,
            ]);

        if ($response->failed()) {
            return response()->json([
                'error'   => 'Error al crear la preferencia de pago en Mercado Pago.',
                'details' => $response->json() ?? $response->body()
            ], 500);
        }

        return response()->json([
            'pedido'     => new PedidoResource($pedido),
            'init_point' => $response->json('init_point')
        ], 201);
    }
}
