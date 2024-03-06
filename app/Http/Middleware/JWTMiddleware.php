<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = FacadesJWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof TokenExpiredException) {
                $newToken = FacadesJWTAuth::parseToken()->refresh();
                return response()->json([
                    'success' => false,
                    'message' => 'Token has expired'
                ], 401);
            } else if ($e instanceof TokenInvalidException) {
                return response()->json(['success' => false, 'message' => 'token Invalid'], 401);
            } else {
                return response()->json(['success' => false, 'message' => 'token Not found'], 401);
            }
        }


        return $next($request);
    }
}
