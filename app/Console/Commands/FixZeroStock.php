<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FirestoreService;

class FixZeroStock extends Command
{
    protected $signature   = 'stock:fix-zeros';
    protected $description = 'Reemplaza stock=0 por stock=1 en todos los talles de productos';

    public function handle(): int
    {
        $docs = FirestoreService::collection('products')->documents();
        $updated = 0;

        foreach ($docs as $doc) {
            if (!$doc->exists()) {
                continue;
            }

            $data   = $doc->data();
            $talles = $data['talles'] ?? [];
            $hasZero = false;

            $fixed = array_map(function ($t) use (&$hasZero) {
                if (isset($t['stock']) && (int) $t['stock'] === 0) {
                    $hasZero = true;
                    $t['stock'] = 1;
                }
                return $t;
            }, $talles);

            if ($hasZero) {
                FirestoreService::collection('products')
                    ->document($doc->id())
                    ->update([['path' => 'talles', 'value' => $fixed]]);

                $this->line("  Actualizado: [{$doc->id()}] {$data['nombre']}");
                $updated++;
            }
        }

        $this->info("Listo. Productos actualizados: {$updated}");
        return Command::SUCCESS;
    }
}
