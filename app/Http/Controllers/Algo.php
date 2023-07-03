<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;

class Algo extends Controller
{
    public function hola(Request $request)
    {
        $respuesta = 'buenos días';
        return response()->json($respuesta, 200);
    }

    public function solo_admin(Request $request){
        $respuesta = 'usted puede administrar';
        return response()->json($respuesta, 200);
    }

    public function esto_tambien_es_solo_para_admin(Request $request){
        $respuesta = 'usted puede administrar también';
        return response()->json($respuesta, 200);
    }

    public function solo_vista(Request $request){
        $respuesta = 'isted puede ver';
        return response()->json($respuesta, 200);
    }

    public function todos_pueden_acceder(Request $request){
        $respuesta = "esto es publico siempre y cuando tenga token";
        return response()->json($respuesta, 200);
    }

    

    
}