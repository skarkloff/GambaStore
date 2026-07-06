<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Google\Auth\AccessToken;

class VerifyGoogleToken
{
    public function handle(Request $request, Closure $next, ?string $mode = null)
    {
        $bearer = $request->bearerToken();

        if (!$bearer) {
            if ($mode === 'optional') {
                return $next($request);
            }
            return response()->json(['error' => 'Token no proporcionado.'], 401);
        }

        try {
            $auth    = new AccessToken();
            $payload = $auth->verify($bearer, [
                'audience' => env('GOOGLE_CLIENT_ID'),
            ]);

            if (!$payload) {
                if ($mode === 'optional') {
                    return $next($request);
                }
                return response()->json(['error' => 'Token inválido.'], 401);
            }

            $request->merge([
                'auth_uid'   => $payload['sub'],
                'auth_email' => $payload['email'] ?? '',
                'auth_name'  => $payload['name']  ?? '',
            ]);
        } catch (\Exception $e) {
            if ($mode === 'optional') {
                return $next($request);
            }
            return response()->json(['error' => 'Token inválido.'], 401);
        }

        return $next($request);
    }
}
