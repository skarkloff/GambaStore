<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FirestoreService;
use Google\Cloud\Firestore\FieldValue;

class MigrateMarcas extends Command
{
    protected $signature   = 'marcas:migrar';
    protected $description = 'Convierte el campo marca (string) de productos a marca_id (referencia a colección marcas)';

    public function handle(): void
    {
        $this->info('Leyendo productos...');

        $productDocs = FirestoreService::collection('products')->documents();
        $products = [];
        foreach ($productDocs as $doc) {
            if ($doc->exists()) {
                $products[] = ['ref' => $doc->reference(), 'data' => $doc->data()];
            }
        }

        // Recolectar strings de marca únicos
        $uniqueMarcas = collect($products)
            ->pluck('data.marca')
            ->filter()
            ->unique()
            ->values();

        if ($uniqueMarcas->isEmpty()) {
            $this->warn('No se encontraron productos con campo marca (string). Nada que migrar.');
            return;
        }

        $this->info("Marcas únicas encontradas: " . $uniqueMarcas->implode(', '));

        // Crear documentos de marca y mapear descripcion → id
        $marcaMap = [];
        foreach ($uniqueMarcas as $descripcion) {
            $ref = FirestoreService::collection('marcas')->add(['descripcion' => $descripcion]);
            $marcaMap[$descripcion] = $ref->id();
            $this->line("  Marca creada: \"{$descripcion}\" → {$ref->id()}");
        }

        // Actualizar cada producto: agregar marca_id, eliminar marca
        $this->info('Actualizando productos...');
        $count = 0;
        foreach ($products as $product) {
            $marcaString = $product['data']['marca'] ?? null;
            if (!$marcaString || !isset($marcaMap[$marcaString])) {
                continue;
            }
            $product['ref']->update([
                ['path' => 'marca_id', 'value' => $marcaMap[$marcaString]],
                ['path' => 'marca',    'value' => FieldValue::deleteField()],
            ]);
            $count++;
        }

        $this->info("Migración completa. {$count} productos actualizados.");
    }
}
