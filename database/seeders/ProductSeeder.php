<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::truncate();

        Product::create([
            'nombre' => 'Adidas Predator Accuracy',
            'marca' => 'Adidas',
            'modelo' => 'Accuracy .3',
            'precio' => 125000,
            'stock' => 15,
            'talles' => [40, 41, 42, 43],
            'imagen_url' => 'https://via.placeholder.com/300x200?text=Adidas+Predator',
            'descripcion' => 'Botines de alta precision para un control total del balon.'
        ]);

        // Botín 2
        Product::create([
            'nombre' => 'Nike Mercurial Superfly',
            'marca' => 'Nike',
            'modelo' => 'Superfly 9',
            'precio' => 138000,
            'stock' => 8,
            'talles' => [39, 40, 42],
            'imagen_url' => 'https://via.placeholder.com/300x200?text=Nike+Mercurial',
            'descripcion' => 'Diseñados para la velocidad explosiva y cambios de ritmo.'
        ]);

        // Botín 3
        Product::create([
            'nombre' => 'Puma Future Ultimate',
            'marca' => 'Puma',
            'modelo' => 'Future 7',
            'precio' => 115000,
            'stock' => 20,
            'talles' => [38, 40, 41, 44],
            'imagen_url' => 'https://via.placeholder.com/300x200?text=Puma+Future',
            'descripcion' => 'Ajuste perfecto y agilidad para creadores de juego.'
        ]);
    }
}
