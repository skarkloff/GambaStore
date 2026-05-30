<?php

namespace App\Http\Controllers;

use App\Services\FirestoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required'    => 'El usuario o correo es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $loginInput = $request->input('login');
        $password   = $request->input('password');

        $documents = FirestoreService::collection('usuarios')->documents();

        $foundUser = null;
        $foundId   = null;
        foreach ($documents as $document) {
            if (!$document->exists()) continue;
            $data = $document->data();
            if (($data['email'] ?? '') === $loginInput || ($data['usuario'] ?? '') === $loginInput) {
                $foundUser = $data;
                $foundId   = $document->id();
                break;
            }
        }

        if (!$foundUser || !Hash::check($password, $foundUser['password'] ?? '')) {
            return back()->withErrors(['login' => 'Usuario o contraseña incorrectos.'])->withInput();
        }

        $rol = $foundUser['rol'] ?? 'Cliente';
        if (!in_array($rol, ['Empleado', 'Administrador'])) {
            return back()->withErrors(['login' => 'No tenés permisos para acceder al panel.'])->withInput();
        }

        session([
            'auth_user' => [
                'id'      => $foundId,
                'name'    => $foundUser['name'] ?? '',
                'usuario' => $foundUser['usuario'] ?? '',
                'email'   => $foundUser['email'] ?? '',
                'rol'     => $rol,
            ]
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('auth_user');
        return redirect('/');
    }

    public function profile()
    {
        return view('auth.profile', ['user' => session('auth_user')]);
    }
}
