<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FirestoreService;

class MigrateTallesFormato extends Command
{
    protected $signature   = 'talles:migrate-formato';
    protected $description = 'Convierte talles guardados como strings simples al formato {talle, stock}';

    public function handle(): int
    {
        $docs    = FirestoreService::collection('products')->documents();
        $updated = 0;

        foreach ($docs as $doc) {
            if (!$doc->exists()) {
                continue;
            }

            $data   = $doc->data();
            $talles = $data['talles'] ?? [];
            $needsFix = false;

            $fixed = array_map(function ($t) use (&$needsFix) {
                if (!is_array($t)) {
                    $needsFix = true;
                    return ['talle' => (string) $t, 'stock' => 1];
                }
                return $t;
            }, $talles);

            if ($needsFix) {
                FirestoreService::collection('products')
                    ->document($doc->id())
                    ->update([['path' => 'talles', 'value' => $fixed]]);

                $this->line("  [{$doc->id()}] {$data['nombre']}: " . count($fixed) . " talles convertidos");
                $updated++;
            }
        }

        $this->info("Listo. Productos actualizados: {$updated}");
        return Command::SUCCESS;
    }
}
