<?php

namespace App\Models;

use App\Services\FirestoreService;

class Marca
{
    public string $id = '';
    public string $descripcion = '';

    public function __construct(array $data = [], string $id = '')
    {
        $this->id          = $id;
        $this->descripcion = $data['descripcion'] ?? '';
    }

    public static function all(): array
    {
        $docs = FirestoreService::collection('marcas')->documents();
        $marcas = [];
        foreach ($docs as $doc) {
            if ($doc->exists()) {
                $marcas[] = new self($doc->data(), $doc->id());
            }
        }
        return $marcas;
    }

    public static function allAsMap(): array
    {
        $map = [];
        foreach (self::all() as $marca) {
            $map[$marca->id] = $marca->descripcion;
        }
        return $map;
    }

    public static function create(array $data): self
    {
        $ref = FirestoreService::collection('marcas')->add($data);
        return new self($data, $ref->id());
    }

    public static function findOrFail(string $id): self
    {
        $doc = FirestoreService::collection('marcas')->document($id)->snapshot();
        if (!$doc->exists()) {
            abort(404);
        }
        return new self($doc->data(), $doc->id());
    }

    public function update(array $data): void
    {
        FirestoreService::collection('marcas')->document($this->id)->set($data, ['merge' => true]);
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function delete(): void
    {
        FirestoreService::collection('marcas')->document($this->id)->delete();
    }
}
