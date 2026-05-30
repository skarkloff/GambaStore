<?php

return [
    'required'             => 'El campo :attribute es obligatorio.',
    'string'               => 'El campo :attribute debe ser texto.',
    'email'                => 'El :attribute debe ser una dirección de correo válida.',
    'regex'                => 'El formato del :attribute no es válido.',
    'max'                  => [
        'string' => 'El :attribute no puede superar :max caracteres.',
    ],
    'min'                  => [
        'string' => 'El :attribute debe tener al menos :min caracteres.',
    ],
    'password' => [
        'min'           => 'La :attribute debe tener al menos :min caracteres.',
        'mixed'         => 'La :attribute debe contener al menos una mayúscula y una minúscula.',
        'numbers'       => 'La :attribute debe contener al menos un número.',
        'symbols'       => 'La :attribute debe contener al menos un símbolo.',
        'uncompromised' => 'La :attribute ingresada fue filtrada en una brecha de datos. Elegí otra.',
    ],
    'attributes' => [
        'name'     => 'nombre',
        'usuario'  => 'usuario',
        'email'    => 'correo electrónico',
        'password' => 'contraseña',
        'rol'      => 'rol',
    ],
];
