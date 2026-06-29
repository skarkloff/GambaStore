<?php

namespace Database\Seeders;

use App\Services\FirestoreService;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    private string $collectionName = 'usuarios';

    public function run(): void
    {
        $email = 'admin@gambastore.com';
        $usuario = 'admin';

        $existing = FirestoreService::collection($this->collectionName)
            ->where('email', '=', $email)
            ->documents();

        foreach ($existing as $doc) {
            if ($doc->exists()) {
                $this->command->warn("Ya existe un usuario con el email {$email}, no se crea uno nuevo.");
                return;
            }
        }

        FirestoreService::collection($this->collectionName)->add([
            'name'       => 'Admin',
            'usuario'    => $usuario,
            'email'      => $email,
            'password'   => bcrypt('56fXrSjWHSpt'),
            'rol'        => 'Administrador',
            'created_at' => now()->toIso8601String(),
        ]);

        $this->command->info("Usuario administrador creado: {$email}");
    }
}
