<?php

namespace App\Models;

use App\Services\FirestoreService;

class Pedido
{
    const ESTADOS = ['pendiente', 'confirmado', 'enviado', 'entregado', 'cancelado'];

    public string $id = '';
    public string $cliente_id = '';
    public string $cliente_nombre = '';
    public string $cliente_email = '';
    public string $estado = 'pendiente';
    public string $fecha = '';
    public array  $items = [];
    public float  $subtotal = 0;
    public float  $descuento = 0;
    public float  $total = 0;
    public string $promocion_codigo = '';
    public string $metodo_pago_id = '';
    public array  $direccion = [];
    public string $numero_tracking = '';
    public string $notas = '';

    public function __construct(array $data = [], string $id = '')
    {
        $this->id               = $id;
        $this->cliente_id       = $data['cliente_id'] ?? '';
        $this->cliente_nombre   = $data['cliente_nombre'] ?? '';
        $this->cliente_email    = $data['cliente_email'] ?? '';
        $this->estado           = $data['estado'] ?? 'pendiente';
        $this->fecha            = $data['fecha'] ?? '';
        $this->items            = $data['items'] ?? [];
        $this->subtotal         = (float) ($data['subtotal'] ?? 0);
        $this->descuento        = (float) ($data['descuento'] ?? 0);
        $this->total            = (float) ($data['total'] ?? 0);
        $this->promocion_codigo = $data['promocion_codigo'] ?? '';
        $this->metodo_pago_id   = $data['metodo_pago_id'] ?? '';
        $this->direccion        = $data['direccion'] ?? [];
        $this->numero_tracking  = $data['numero_tracking'] ?? '';
        $this->notas            = $data['notas'] ?? '';
    }

    public static function all(?string $estado = null): array
    {
        $query = FirestoreService::collection('pedidos');
        if ($estado) {
            $query = $query->where('estado', '=', $estado);
        }
        $docs  = $query->documents();
        $items = [];
        foreach ($docs as $doc) {
            if ($doc->exists()) {
                $items[] = new self($doc->data(), $doc->id());
            }
        }
        usort($items, fn($a, $b) => strcmp($b->fecha, $a->fecha));
        return $items;
    }

    public static function create(array $data): self
    {
        $ref = FirestoreService::collection('pedidos')->add($data);
        return new self($data, $ref->id());
    }

    public static function findOrFail(string $id): self
    {
        $doc = FirestoreService::collection('pedidos')->document($id)->snapshot();
        if (!$doc->exists()) {
            abort(404);
        }
        return new self($doc->data(), $doc->id());
    }

    public function update(array $data): void
    {
        FirestoreService::collection('pedidos')->document($this->id)->set($data, ['merge' => true]);
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function delete(): void
    {
        FirestoreService::collection('pedidos')->document($this->id)->delete();
    }
}
