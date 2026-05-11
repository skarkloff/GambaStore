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
        foreach (Product::all() as $product) {
            $product->delete();
        }

        Product::create([
            'nombre' => 'Adidas Predator Mania',
            'marca' => 'Adidas',
            'modelo' => 'Mania 2002',
            'precio' => 145000,
            'stock' => 10,
            'talles' => ['39', '40', '41', '42', '43'],
            'imagen_url' => 'https://placehold.co/300x200/ffde00/000000?text=Predator+Mania',
            'descripcion' => 'El clásico de los clásicos. Usado por Zidane en el Mundial 2002. Control total con los rubber fins.',
        ]);

        Product::create([
            'nombre' => 'Nike Mercurial R9',
            'marca' => 'Nike',
            'modelo' => 'Mercurial 2002',
            'precio' => 138000,
            'stock' => 6,
            'talles' => ['40', '41', '42'],
            'imagen_url' => 'https://placehold.co/300x200/ffde00/000000?text=Mercurial+R9',
            'descripcion' => 'El botín de Ronaldo en Corea-Japón 2002. Velocidad pura, suela de TPU y corte bajo.',
        ]);

        Product::create([
            'nombre' => 'Adidas Copa Mundial',
            'marca' => 'Adidas',
            'modelo' => 'Copa Mundial OG',
            'precio' => 98000,
            'stock' => 25,
            'talles' => ['38', '39', '40', '41', '42', '43', '44'],
            'imagen_url' => 'https://placehold.co/300x200/ffde00/000000?text=Copa+Mundial',
            'descripcion' => 'El botín más vendido de la historia. Cuero canguro, suela de tacos intercambiables. Desde 1979.',
        ]);

        Product::create([
            'nombre' => 'Nike Total 90 Laser',
            'marca' => 'Nike',
            'modelo' => 'Total 90 Laser I',
            'precio' => 122000,
            'stock' => 8,
            'talles' => ['40', '41', '42', '43'],
            'imagen_url' => 'https://placehold.co/300x200/ffde00/000000?text=Total+90+Laser',
            'descripcion' => 'La zona de strike Power Bands revolucionó los tiros libres. Usado por Rooney y Ronaldinho.',
        ]);

        Product::create([
            'nombre' => 'Puma King Platinum',
            'marca' => 'Puma',
            'modelo' => 'King Platinum',
            'precio' => 89000,
            'stock' => 14,
            'talles' => ['39', '40', '41', '42'],
            'imagen_url' => 'https://placehold.co/300x200/ffde00/000000?text=Puma+King',
            'descripcion' => 'Ícono del fútbol mundial desde los 70. Pelé, Maradona y Cruyff lo eligieron. Cuero premium.',
        ]);

        Product::create([
            'nombre' => 'Nike Tiempo Legend',
            'marca' => 'Nike',
            'modelo' => 'Tiempo Legend IV',
            'precio' => 105000,
            'stock' => 18,
            'talles' => ['38', '40', '41', '42', '43'],
            'imagen_url' => 'https://placehold.co/300x200/ffde00/000000?text=Tiempo+Legend',
            'descripcion' => 'Cuero ACC para todo clima. El favorito de los mediocampistas con criterio.',
        ]);

        Product::create([
            'nombre' => 'Adidas F50 adizero',
            'marca' => 'Adidas',
            'modelo' => 'F50 adizero SL',
            'precio' => 118000,
            'stock' => 9,
            'talles' => ['39', '41', '42', '43'],
            'imagen_url' => 'https://placehold.co/300x200/ffde00/000000?text=F50+adizero',
            'descripcion' => 'El más liviano de su era: 165 gramos. Messi lo usó para su primer Balón de Oro.',
        ]);

        Product::create([
            'nombre' => 'Mizuno Morelia II',
            'marca' => 'Mizuno',
            'modelo' => 'Morelia II Classic',
            'precio' => 132000,
            'stock' => 7,
            'talles' => ['40', '41', '42'],
            'imagen_url' => 'https://placehold.co/300x200/ffde00/000000?text=Morelia+II',
            'descripcion' => 'Cuero canguro japonés de la mejor calidad. El botín más fino para los que saben.',
        ]);
    }
}
