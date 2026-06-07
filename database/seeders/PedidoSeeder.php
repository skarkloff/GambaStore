<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pedido;
use App\Models\Product;
use App\Models\MetodoPago;

class PedidoSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Pedido::all() as $pedido) {
            $pedido->delete();
        }

        $productos = [];
        foreach (Product::all() as $p) {
            $productos[$p->id] = $p;
        }

        $marcas = [];
        foreach (\App\Models\Marca::all() as $m) {
            $marcas[$m->id] = $m->descripcion;
        }

        $metodos = MetodoPago::all();
        $metodoIds = array_map(fn($m) => $m->id, $metodos);
        $metodoMap = [];
        foreach ($metodos as $m) {
            $metodoMap[$m->descripcion] = $m->id;
        }

        $copa    = $this->findProduct($productos, 'Copa Mundial');
        $tiempo  = $this->findProduct($productos, 'Tiempo Legend');
        $mercurial = $this->findProduct($productos, 'Mercurial');
        $f50     = $this->findProduct($productos, 'F50');

        $mpId  = $metodoMap['Mercado Pago']         ?? $metodoIds[0] ?? '';
        $tfId  = $metodoMap['Transferencia bancaria'] ?? $metodoIds[1] ?? '';
        $efId  = $metodoMap['Efectivo']               ?? $metodoIds[2] ?? '';
        $dbId  = $metodoMap['Tarjeta de débito']      ?? $metodoIds[3] ?? '';

        // 1. Pendiente
        \App\Services\FirestoreService::collection('pedidos')->add([
            'cliente_id'       => 'cliente_001',
            'cliente_nombre'   => 'Lucía Fernández',
            'cliente_email'    => 'lucia.fernandez@gmail.com',
            'estado'           => 'pendiente',
            'fecha'            => now()->subDays(1)->toIso8601String(),
            'items'            => [
                $this->item($copa,   $marcas, '41', 1),
                $this->item($tiempo, $marcas, '40', 1),
            ],
            'subtotal'         => ($copa ? $copa->precio : 98000) + ($tiempo ? $tiempo->precio : 105000),
            'descuento'        => 0.0,
            'total'            => ($copa ? $copa->precio : 98000) + ($tiempo ? $tiempo->precio : 105000),
            'promocion_codigo' => '',
            'metodo_pago_id'   => $mpId,
            'direccion'        => ['calle' => 'Av. Corrientes', 'numero' => '1234', 'ciudad' => 'Buenos Aires', 'provincia' => 'CABA', 'cp' => '1043'],
            'numero_tracking'  => '',
            'notas'            => '',
        ]);

        // 2. Confirmado
        \App\Services\FirestoreService::collection('pedidos')->add([
            'cliente_id'       => 'cliente_002',
            'cliente_nombre'   => 'Martín Gómez',
            'cliente_email'    => 'martin.gomez@hotmail.com',
            'estado'           => 'confirmado',
            'fecha'            => now()->subDays(3)->toIso8601String(),
            'items'            => [
                $this->item($mercurial, $marcas, '42', 1),
            ],
            'subtotal'         => $mercurial ? $mercurial->precio : 138000,
            'descuento'        => $mercurial ? round($mercurial->precio * 0.1, 2) : 13800,
            'total'            => $mercurial ? round($mercurial->precio * 0.9, 2) : 124200,
            'promocion_codigo' => 'VERANO10',
            'metodo_pago_id'   => $tfId,
            'direccion'        => ['calle' => 'San Martín', 'numero' => '567', 'ciudad' => 'Rosario', 'provincia' => 'Santa Fe', 'cp' => '2000'],
            'numero_tracking'  => '',
            'notas'            => 'Por favor embalar bien.',
        ]);

        // 3. Enviado (con tracking)
        \App\Services\FirestoreService::collection('pedidos')->add([
            'cliente_id'       => 'cliente_003',
            'cliente_nombre'   => 'Valentina Torres',
            'cliente_email'    => 'valen.torres@gmail.com',
            'estado'           => 'enviado',
            'fecha'            => now()->subDays(7)->toIso8601String(),
            'items'            => [
                $this->item($f50,  $marcas, '39', 1),
                $this->item($copa, $marcas, '43', 2),
            ],
            'subtotal'         => ($f50 ? $f50->precio : 118000) + ($copa ? $copa->precio * 2 : 196000),
            'descuento'        => 0.0,
            'total'            => ($f50 ? $f50->precio : 118000) + ($copa ? $copa->precio * 2 : 196000),
            'promocion_codigo' => '',
            'metodo_pago_id'   => $efId,
            'direccion'        => ['calle' => 'Belgrano', 'numero' => '890', 'ciudad' => 'Córdoba', 'provincia' => 'Córdoba', 'cp' => '5000'],
            'numero_tracking'  => 'OCA-98271364',
            'notas'            => '',
        ]);

        // 4. Entregado
        \App\Services\FirestoreService::collection('pedidos')->add([
            'cliente_id'       => 'cliente_004',
            'cliente_nombre'   => 'Diego Ramírez',
            'cliente_email'    => 'diego.ramirez@yahoo.com',
            'estado'           => 'entregado',
            'fecha'            => now()->subDays(14)->toIso8601String(),
            'items'            => [
                $this->item($tiempo, $marcas, '43', 1),
            ],
            'subtotal'         => $tiempo ? $tiempo->precio : 105000,
            'descuento'        => 0.0,
            'total'            => $tiempo ? $tiempo->precio : 105000,
            'promocion_codigo' => '',
            'metodo_pago_id'   => $dbId,
            'direccion'        => ['calle' => 'Rivadavia', 'numero' => '321', 'ciudad' => 'Mendoza', 'provincia' => 'Mendoza', 'cp' => '5500'],
            'numero_tracking'  => 'ANDREANI-44512890',
            'notas'            => 'Dejar en portería.',
        ]);
    }

    private function findProduct(array $productos, string $keyword): ?object
    {
        foreach ($productos as $p) {
            if (stripos($p->nombre, $keyword) !== false) {
                return $p;
            }
        }
        return null;
    }

    private function item(?object $product, array $marcas, string $talle, int $cantidad): array
    {
        if (!$product) {
            return ['producto_id' => '', 'nombre' => 'Producto', 'marca' => '—', 'modelo' => '—', 'talle' => $talle, 'cantidad' => $cantidad, 'precio_unitario' => 0.0];
        }
        return [
            'producto_id'    => $product->id,
            'nombre'         => $product->nombre,
            'marca'          => $marcas[$product->marca_id] ?? '—',
            'modelo'         => $product->modelo,
            'talle'          => $talle,
            'cantidad'       => $cantidad,
            'precio_unitario' => $product->precio,
        ];
    }
}
