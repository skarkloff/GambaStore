<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promocion;
use Illuminate\Http\Request;

class PromocionController extends Controller
{
    public function activas()
    {
        $hoy      = now()->toDateString();
        $activas  = array_filter(Promocion::all(), fn($p) =>
            $p->activa &&
            $p->fecha_inicio <= $hoy &&
            $p->fecha_fin    >= $hoy &&
            $p->codigo === ''
        );

        return response()->json(['data' => array_values(array_map(
            fn($p) => $this->format($p), $activas
        ))]);
    }

    public function validarCodigo(Request $request)
    {
        $request->validate([
            'codigo'   => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $codigo   = strtoupper(trim($request->codigo));
        $subtotal = (float) $request->subtotal;
        $hoy      = now()->toDateString();

        $promo = collect(Promocion::all())->first(fn($p) =>
            strtoupper($p->codigo) === $codigo &&
            $p->activa &&
            $p->fecha_inicio <= $hoy &&
            $p->fecha_fin    >= $hoy
        );

        if (!$promo) {
            return response()->json(['error' => 'Código inválido o expirado.'], 422);
        }

        if ($promo->minimo_compra !== null && $subtotal < $promo->minimo_compra) {
            return response()->json([
                'error' => 'El monto mínimo para este cupón es $' . number_format($promo->minimo_compra, 2, ',', '.'),
            ], 422);
        }

        $descuento = $promo->tipo === 'porcentaje'
            ? round($subtotal * $promo->valor / 100, 2)
            : min($promo->valor, $subtotal);

        return response()->json([
            'data' => [
                'promocion' => $this->format($promo),
                'descuento' => $descuento,
                'total'     => round($subtotal - $descuento, 2),
            ],
        ]);
    }

    private function format(Promocion $p): array
    {
        return [
            'id'             => $p->id,
            'nombre'         => $p->nombre,
            'tipo'           => $p->tipo,
            'valor'          => $p->valor,
            'aplica_a'       => $p->aplica_a,
            'marca_id'       => $p->marca_id       ?: null,
            'tipo_producto'  => $p->tipo_producto   ?: null,
            'producto_id'    => $p->producto_id     ?: null,
            'minimo_compra'  => $p->minimo_compra,
        ];
    }
}
