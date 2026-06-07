<?php

namespace App\Models;

use App\Services\FirestoreService;

class Promocion
{
    const TIPOS = ['porcentaje', 'monto_fijo'];
    const APLICA_A = ['todo', 'marca', 'tipo', 'producto'];

    public string $id = '';
    public string $nombre = '';
    public string $tipo = '';
    public float $valor = 0;
    public string $codigo = '';
    public string $fecha_inicio = '';
    public string $fecha_fin = '';
    public ?float $minimo_compra = null;
    public string $aplica_a = 'todo';
    public string $marca_id = '';
    public string $tipo_producto = '';
    public string $producto_id = '';
    public bool $activa = true;

    public function __construct(array $data = [], string $id = '')
    {
        $this->id            = $id;
        $this->nombre        = $data['nombre'] ?? '';
        $this->tipo          = $data['tipo'] ?? '';
        $this->valor         = (float) ($data['valor'] ?? 0);
        $this->codigo        = $data['codigo'] ?? '';
        $this->fecha_inicio  = $data['fecha_inicio'] ?? '';
        $this->fecha_fin     = $data['fecha_fin'] ?? '';
        $this->minimo_compra = isset($data['minimo_compra']) && $data['minimo_compra'] !== '' ? (float) $data['minimo_compra'] : null;
        $this->aplica_a      = $data['aplica_a'] ?? 'todo';
        $this->marca_id      = $data['marca_id'] ?? '';
        $this->tipo_producto = $data['tipo_producto'] ?? '';
        $this->producto_id   = $data['producto_id'] ?? '';
        $this->activa        = (bool) ($data['activa'] ?? true);
    }

    public static function all(): array
    {
        $docs = FirestoreService::collection('promociones')->documents();
        $items = [];
        foreach ($docs as $doc) {
            if ($doc->exists()) {
                $items[] = new self($doc->data(), $doc->id());
            }
        }
        return $items;
    }

    public static function create(array $data): self
    {
        $ref = FirestoreService::collection('promociones')->add($data);
        return new self($data, $ref->id());
    }

    public static function findOrFail(string $id): self
    {
        $doc = FirestoreService::collection('promociones')->document($id)->snapshot();
        if (!$doc->exists()) {
            abort(404);
        }
        return new self($doc->data(), $doc->id());
    }

    public function update(array $data): void
    {
        FirestoreService::collection('promociones')->document($this->id)->set($data, ['merge' => false]);
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function delete(): void
    {
        FirestoreService::collection('promociones')->document($this->id)->delete();
    }

    public function vigente(): bool
    {
        $hoy = now()->toDateString();
        return $this->activa && $this->fecha_inicio <= $hoy && $this->fecha_fin >= $hoy;
    }
}
