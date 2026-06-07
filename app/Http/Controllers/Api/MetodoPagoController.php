<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MetodoPago;

class MetodoPagoController extends Controller
{
    public function index()
    {
        $activos = array_filter(MetodoPago::all(), fn($m) => $m->activo);

        $data = array_map(fn($m) => [
            'id'          => $m->id,
            'descripcion' => $m->descripcion,
        ], array_values($activos));

        return response()->json(['data' => $data]);
    }
}
