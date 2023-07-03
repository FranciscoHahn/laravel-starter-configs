<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Illuminate\Http\Response;
use Firebase\JWT\Key;

class VerificarToken
{
    public function handle($request, Closure $next, ...$perfilesPermitidos)
    {
        $authorizationHeader = $request->header('Authorization');

        if (!$authorizationHeader) {
            return response()->json(['mensaje' => 'Token no proporcionado'], Response::HTTP_UNAUTHORIZED);
        }

        // Extraer el token de autorización del encabezado
        $token = $this->extractTokenFromHeader($authorizationHeader);

        // Verificar la validez del token
        try {
            $decoded = JWT::decode($token, new Key(env('LLAVE_TOKEN'), env('LLAVE_ALG')));

            // Verificar la expiración del token
            $currentTime = time();
            $expirationTime = $decoded->exp;

            if ($expirationTime < $currentTime) {
                return response()->json(['mensaje' => 'Token expirado'], Response::HTTP_UNAUTHORIZED);
            }

            $perfil = $decoded->perfil;

            if ($perfilesPermitidos != ['ALL'] && !in_array($perfil, $perfilesPermitidos)) {
                return response()->json(['mensaje' => 'Acceso no autorizado'], Response::HTTP_FORBIDDEN);
            }
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Token inválido'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }

    private function extractTokenFromHeader($authorizationHeader)
    {
        $parts = explode(' ', $authorizationHeader);
        if (count($parts) !== 2 || $parts[0] !== 'Bearer') {
            return null;
        }

        return $parts[1];
    }
}