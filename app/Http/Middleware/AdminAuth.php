<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('auth_user')) {
            return redirect('/')->with('open_login', true);
        }
        return $next($request);
    }
}
