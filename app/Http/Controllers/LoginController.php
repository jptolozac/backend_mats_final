<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        //dd('holii');
        $this->validateLogin($request);
        $credenciales = $request->only('email', 'password');

        if(Auth::guard('admin')->attempt($credenciales)){
            //dd(Auth::guard('admin')->user());
            return response()->json([
                'token' => Auth::guard('admin')->user()->createToken($request->email)->plainTextToken,
                'tipo_usuario' => ['perfil' => 'administrador'],
                'permiso_noticias' => false,
                'permiso_preguntas' => false,
                'permiso_mesa_ayuda' => false,
                'message' => 'ok'
            ]);
        }
        elseif(Auth::attempt($credenciales)){
            $permiso_noticias = false;
            $permiso_preguntas = false;
            $permiso_mesa_ayuda = false;
            $permisos = ($request->user()->permisosUsuario());
            foreach($permisos as $permiso){
                switch($permiso->id){
                    case 1: $permiso_noticias = true; break;
                    case 2: $permiso_preguntas = true; break;
                    case 3: $permiso_mesa_ayuda = true; break;
                };
            }

            return response()->json([
                'token' => $request->user()->createToken($request->email)->plainTextToken,
                'tipo_usuario' => [
                    'id' => $request->user()->TipoUsuario->id, 
                    'perfil' => $request->user()->TipoUsuario->perfil
                ],
                'permiso_noticias' => $permiso_noticias,
                'permiso_preguntas' => $permiso_preguntas,
                'permiso_mesa_ayuda' => $permiso_mesa_ayuda,
                'message' => 'ok'
            ]);
        }

        return response()->json([
            'message' => 'No tiene permiso'
        ], 401);
    }

    public function validateLogin(Request $request){
        return $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
    }
}
