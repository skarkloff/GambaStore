<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePedidoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items'                    => 'required|array|min:1',
            'items.*.producto_id'      => 'required|string',
            'items.*.talle'            => 'required|string',
            'items.*.cantidad'         => 'required|integer|min:1',
            'items.*.precio_unitario'  => 'required|numeric|min:0',
            'metodo_pago_id'           => 'required|string',
            'direccion'                => 'required|array',
            'direccion.calle'          => 'required|string',
            'direccion.numero'         => 'required|string',
            'direccion.ciudad'         => 'required|string',
            'direccion.provincia'      => 'required|string',
            'direccion.cp'             => 'required|string',
            'promocion_codigo'         => 'nullable|string',
            'notas'                    => 'nullable|string|max:500',
        ];
    }

    protected function failedValidation(Validator $validator): never
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], 422)
        );
    }
}
