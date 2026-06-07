<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PedidoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'estado'           => $this->estado,
            'fecha'            => $this->fecha
                ? Carbon::parse($this->fecha)->format('d/m/Y H:i')
                : null,
            'items'            => $this->items,
            'subtotal'         => $this->subtotal,
            'descuento'        => $this->descuento,
            'total'            => $this->total,
            'promocion_codigo' => $this->promocion_codigo,
            'metodo_pago_id'   => $this->metodo_pago_id,
            'direccion'        => $this->direccion,
            'numero_tracking'  => $this->numero_tracking ?: null,
            'notas'            => $this->notas ?: null,
        ];
    }
}
