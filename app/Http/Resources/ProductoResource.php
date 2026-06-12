<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'nombre'      => $this->nombre,
            'marca_id'    => $this->marca_id,
            'modelo'      => $this->modelo,
            'tipo'        => $this->tipo,
            'precio'      => $this->precio,
            'talles'      => $this->talles,
            'imagen_url'  => $this->imagen_url,
            'descripcion' => $this->descripcion,
        ];
    }
}
