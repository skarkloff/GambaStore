<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = session('auth_user');
        if (!$user || $user['rol'] !== 'Administrador') {
            return redirect()->route('admin.dashboard')
                ->with('error', 'No tenés permisos para acceder a esta sección.');
        }
        return $next($request);
    }
}
