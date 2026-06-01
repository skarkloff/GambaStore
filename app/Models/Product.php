<?php

namespace App\Models;

use App\Services\FirestoreService;

class Product
{
    const TIPOS = [
        'Terreno firme',
        'Terreno blando',
        'Césped artificial',
        'Pasto sintético',
        'Interior',
        'Retro',
    ];

    public string $id = '';
    public string $nombre = '';
    public string $marca_id = '';
    public string $modelo = '';
    public string $tipo = '';
    public float $precio = 0;
    public int $stock = 0;
    public array|string $talles = [];
    public string $imagen_url = '';
    public string $descripcion = '';

    public function __construct(array $data = [], string $id = '')
    {
        $this->id          = $id;
        $this->nombre      = $data['nombre'] ?? '';
        $this->marca_id    = $data['marca_id'] ?? '';
        $this->modelo      = $data['modelo'] ?? '';
        $this->tipo        = $data['tipo'] ?? '';
        $this->precio      = (float) ($data['precio'] ?? 0);
        $this->stock       = (int) ($data['stock'] ?? 0);
        $this->talles      = $data['talles'] ?? [];
        $this->imagen_url  = $data['imagen_url'] ?? '';
        $this->descripcion = $data['descripcion'] ?? '';
    }

    public static function all(): array
    {
        $docs = FirestoreService::collection('products')->documents();
        $products = [];
        foreach ($docs as $doc) {
            if ($doc->exists()) {
                $products[] = new self($doc->data(), $doc->id());
            }
        }
        return $products;
    }

    public static function create(array $data): self
    {
        $ref = FirestoreService::collection('products')->add($data);
        return new self($data, $ref->id());
    }

    public static function findOrFail(string $id): self
    {
        $doc = FirestoreService::collection('products')->document($id)->snapshot();
        if (!$doc->exists()) {
            abort(404);
        }
        return new self($doc->data(), $doc->id());
    }

    public function update(array $data): void
    {
        FirestoreService::collection('products')->document($this->id)->set($data, ['merge' => true]);
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function delete(): void
    {
        FirestoreService::collection('products')->document($this->id)->delete();
    }
}
