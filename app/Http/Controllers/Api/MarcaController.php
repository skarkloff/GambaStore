<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Marca;

class MarcaController extends Controller
{
    public function index()
    {
        $marcas = array_map(fn($m) => [
            'id'          => $m->id,
            'descripcion' => $m->descripcion,
        ], Marca::all());

        return response()->json(['data' => array_values($marcas)]);
    }
}
