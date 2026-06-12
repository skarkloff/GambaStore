<?php

namespace App\Models;

use App\Services\FirestoreService;

class MetodoPago
{
    public string $id = '';
    public string $descripcion = '';
    public bool $activo = true;

    public function __construct(array $data = [], string $id = '')
    {
        $this->id          = $id;
        $this->descripcion = $data['descripcion'] ?? '';
        $this->activo      = (bool) ($data['activo'] ?? true);
    }

    public static function allAsMap(): array
    {
        $map = [];
        foreach (self::all() as $metodo) {
            $map[$metodo->id] = $metodo->descripcion;
        }
        return $map;
    }

    public static function all(): array
    {
        $docs  = FirestoreService::collection('metodos_pago')->documents();
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
        $ref = FirestoreService::collection('metodos_pago')->add($data);
        return new self($data, $ref->id());
    }

    public static function findOrFail(string $id): self
    {
        $doc = FirestoreService::collection('metodos_pago')->document($id)->snapshot();
        if (!$doc->exists()) {
            abort(404);
        }
        return new self($doc->data(), $doc->id());
    }

    public function update(array $data): void
    {
        FirestoreService::collection('metodos_pago')->document($this->id)->set($data, ['merge' => false]);
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function delete(): void
    {
        FirestoreService::collection('metodos_pago')->document($this->id)->delete();
    }
}
