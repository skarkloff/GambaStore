<?php

namespace App\Models;

use MongoDb\Laravel\Eloquent\Model; 

class Product extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'products';

    protected $fillable = [
        'nombre',
        'marca',
        'modelo',
        'precio',
        'stock',
        'talles',
        'imagen_url',
        'descripcion'
    ];
}
