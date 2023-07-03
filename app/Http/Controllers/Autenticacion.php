<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Autenticacion extends Controller
{
    public function autenticar(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $perfil = $request->input('perfil');
    
        $payload = [
            'sub' => $username, // Identificador único del usuario
            'exp' => time() + (60 * 60 * env('VALID_TOKEN_HOURS')), // Expiración en 24 horas
            'perfil' => $perfil
        ];
    
        if ($username == 'user' && $password == '123') {
            try {
                $token = JWT::encode($payload, env('LLAVE_TOKEN'), env('LLAVE_ALG'));
    
                $respuesta = [
                    'autenticacion-valida' => true,
                    'token' => $token,
                    'mensaje' => 'Inicio de sesión correcto'
                ];
    
                return response()->json($respuesta, 200);
            } catch (\Exception $e) {
                // Error al generar el token
                $respuesta = [
                    'autenticacion-valida' => false,
                    'mensaje' => 'No se pudo generar el token'
                ];
    
                return response()->json($respuesta, 500);
            }
        } else {
            $respuesta = [
                'autenticacion-valida' => false,
                'mensaje' => 'Usuario o contraseña inválidos'
            ];
    
            return response()->json($respuesta, 401);
        }
    }
}
