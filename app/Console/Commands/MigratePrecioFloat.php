<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FirestoreService;

class MigratePrecioFloat extends Command
{
    protected $signature   = 'precio:migrate-float';
    protected $description = 'Convierte el campo precio de string a float en todos los productos';

    public function handle(): int
    {
        $docs    = FirestoreService::collection('products')->documents();
        $updated = 0;

        foreach ($docs as $doc) {
            if (!$doc->exists()) {
                continue;
            }

            $data   = $doc->data();
            $precio = $data['precio'] ?? null;

            if (!is_float($precio)) {
                $nuevo = (float) str_replace(',', '.', (string) $precio);

                FirestoreService::collection('products')
                    ->document($doc->id())
                    ->update([['path' => 'precio', 'value' => $nuevo]]);

                $this->line("  [{$doc->id()}] {$data['nombre']}: {$precio} → {$nuevo}");
                $updated++;
            }
        }

        $this->info("Listo. Productos actualizados: {$updated}");
        return Command::SUCCESS;
    }
}
