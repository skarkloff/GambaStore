<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MetodoPago;

class MetodoPagoSeeder extends Seeder
{
    public function run(): void
    {
        $nuevos = [
            ['descripcion' => 'Transferencia bancaria', 'activo' => true],
            ['descripcion' => 'Efectivo',               'activo' => true],
            ['descripcion' => 'Tarjeta de débito',      'activo' => true],
            ['descripcion' => 'Tarjeta de crédito',     'activo' => true],
        ];

        foreach ($nuevos as $data) {
            MetodoPago::create($data);
        }
    }
}
