<?php

namespace App\Http\Controllers;

use App\Services\FirestoreService;
use Illuminate\Http\Request;

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
                    'id'    => $document->id(),
                    'name'  => $data['name'] ?? 'Sin nombre',
                    'email' => $data['email'] ?? 'Sin email',
                    'rol'   => $data['rol'] ?? 'Cliente',
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
        // Validamos los datos básicos
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
            'rol'      => 'required|string'
        ]);

        // 2. Guardar en Firestore como un nuevo documento
        FirestoreService::collection($this->collectionName)->add([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
            'rol'      => $data['rol'],
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
            'id'    => $document->id(),
            'name'  => $data['name'] ?? '',
            'email' => $data['email'] ?? '',
            'rol'   => $data['rol'] ?? 'Cliente',
        ];

        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'nullable|string|min:6',
            'rol'      => 'required|string'
        ]);

        $updateData = [
            'name'  => $data['name'],
            'email' => $data['email'],
            'rol'   => $data['rol']
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

    public function destroy($id)
    {
        // 5. Eliminar el documento de la colección de Firestore
        FirestoreService::collection($this->collectionName)->document($id)->delete();

        // CORREGIDO: Redirige a 'users.index'
        return redirect()->route('users.index')->with('success', 'Usuario eliminado con éxito.');
    }
}