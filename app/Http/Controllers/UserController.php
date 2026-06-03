<?php

namespace App\Http\Controllers;

use App\Services\FirestoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    private string $collectionName = 'usuarios';

    public function index()
    {
        // 1. Traer los documentos reales de Firestore
        $documents = FirestoreService::collection($this->collectionName)->documents();
        
        $users = collect();
        foreach ($documents as $document) {
            if ($document->exists()) {
                $data = $document->data();
                $users->push((object)[
                    'id'      => $document->id(),
                    'name'    => $data['name'] ?? 'Sin nombre',
                    'usuario' => $data['usuario'] ?? '',
                    'email'   => $data['email'] ?? 'Sin email',
                    'rol'     => $data['rol'] ?? 'Cliente',
                ]);
            }
        }

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'usuario'  => 'required|string|max:50',
            'email'    => ['required', 'regex:/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/'],
            'password' => ['required', Password::min(8)->mixedCase()->numbers()],
            'rol'      => 'required|string'
        ]);

        $validator->after(function ($validator) use ($request) {
            if (!$this->isUnique('usuario', $request->usuario)) {
                $validator->errors()->add('usuario', 'El nombre de usuario ya está en uso.');
            }
            if (!$this->isUnique('email', $request->email)) {
                $validator->errors()->add('email', 'El correo electrónico ya está registrado.');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        FirestoreService::collection($this->collectionName)->add([
            'name'       => $data['name'],
            'usuario'    => $data['usuario'],
            'email'      => $data['email'],
            'password'   => bcrypt($data['password']),
            'rol'        => $data['rol'],
            'created_at' => now()->toIso8601String()
        ]);

        // CORREGIDO: Redirige a 'users.index' como tenés en web.php
        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit($id)
    {
        // 3. Buscar el documento específico por su ID único de Firestore
        $document = FirestoreService::collection($this->collectionName)->document($id)->snapshot();

        if (!$document->exists()) {
            // CORREGIDO: Redirige a 'users.index'
            return redirect()->route('users.index')->with('error', 'Usuario no encontrado.');
        }

        $data = $document->data();
        $user = (object)[
            'id'      => $document->id(),
            'name'    => $data['name'] ?? '',
            'usuario' => $data['usuario'] ?? '',
            'email'   => $data['email'] ?? '',
            'rol'     => $data['rol'] ?? 'Cliente',
        ];

        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'usuario'  => 'required|string|max:50',
            'email'    => ['required', 'regex:/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/'],
            'password' => ['nullable', Password::min(8)->mixedCase()->numbers()],
            'rol'      => 'required|string'
        ]);

        $validator->after(function ($validator) use ($request, $id) {
            if (!$this->isUnique('usuario', $request->usuario, $id)) {
                $validator->errors()->add('usuario', 'El nombre de usuario ya está en uso.');
            }
            if (!$this->isUnique('email', $request->email, $id)) {
                $validator->errors()->add('email', 'El correo electrónico ya está registrado.');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        $updateData = [
            'name'    => $data['name'],
            'usuario' => $data['usuario'],
            'email'   => $data['email'],
            'rol'     => $data['rol']
        ];

        // Si ingresó contraseña, la encriptamos de forma segura con la función global
        if (!empty($data['password'])) {
            $updateData['password'] = bcrypt($data['password']); // <-- Corregido para evitar fallas
        }

        // Impactamos en Firestore
        FirestoreService::collection($this->collectionName)->document($id)->set($updateData, ['merge' => true]);

        // Redirección limpia a la tabla
        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    private function isUnique(string $field, string $value, ?string $excludeId = null): bool
    {
        $docs = FirestoreService::collection($this->collectionName)
            ->where($field, '=', $value)
            ->documents();

        foreach ($docs as $doc) {
            if ($doc->exists() && $doc->id() !== $excludeId) {
                return false;
            }
        }
        return true;
    }

    public function destroy($id)
    {
        // 5. Eliminar el documento de la colección de Firestore
        FirestoreService::collection($this->collectionName)->document($id)->delete();

        // CORREGIDO: Redirige a 'users.index'
        return redirect()->route('users.index')->with('success', 'Usuario eliminado con éxito.');
    }
}