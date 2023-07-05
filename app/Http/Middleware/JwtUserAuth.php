<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtUserAuth extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token_role = $this->auth->parseToken()->getClaim('role');
        } catch (JWTException $e) {
            return response()->json(['result' => 'false', 'message' => 'Unauthorized'], 401);
        }

        if ($token_role != 'user') {
            return response()->json(['result' => 'false', 'message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
