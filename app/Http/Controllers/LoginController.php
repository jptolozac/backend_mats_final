<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        dd('holii');
        $this->validateLogin($request);
        $credenciales = $request->only('email', 'password');

        if(Auth::guard('admin')->attempt($credenciales)){
            //dd(Auth::guard('admin')->user());
            return response()->json([
                'token' => Auth::guard('admin')->user()->createToken($request->email)->plainTextToken,
                'tipo_usuario' => ['perfil' => 'administrador'],
                'permiso' => '1',
                'message' => 'ok'
            ]);
        }
        elseif(Auth::attempt($credenciales)){
            return response()->json([
                'token' => $request->user()->createToken($request->email)->plainTextToken,
                'tipo_usuario' => [
                    'id' => $request->user()->TipoUsuario->id, 
                    'perfil' => $request->user()->TipoUsuario->perfil
                ],
                'permiso' => $request->user()->Permiso->id,
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
