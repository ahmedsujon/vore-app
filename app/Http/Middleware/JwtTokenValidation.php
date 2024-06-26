<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class JwtTokenValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $token = $request->bearerToken()) {
            return response()->json(['error' => 'Token not provided'], 401);
        }
        try {
            $user = JWTAuth::authenticate($token);
        } catch (Exception $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }
        return $next($request);
    }
}
