<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\PermisosUsuario;
use Illuminate\Http\Request;

class PermisoUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PermisosUsuario $permisosUsuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PermisosUsuario $permisosUsuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $email)
    {
        if(request()->permiso == 'noticias'){
            $permisosUsuarios = \App\Models\User::join('permisos_usuarios', 'users.id', '=', 'permisos_usuarios.user_id')
                            ->select('permisos_usuarios.id')
                            ->where('users.email', $email)
                            ->get();
            foreach($permisosUsuarios as $permisoUsuario){
                PermisosUsuario::where('id',$permisoUsuario->id)->delete();
                //dump($permiso);
            }
        }

        if(request()->permiso == 'preguntas'){
            $permisosUsuarios = \App\Models\User::join('permisos_usuarios', 'users.id', '=', 'permisos_usuarios.user_id')
                            ->select('permisos_usuarios.id')
                            ->where('users.email', $email)
                            ->where('permisos_usuarios.permiso_id', 2)
                            ->get();
            //dd($permisosUsuarios);
            foreach($permisosUsuarios as $permisoUsuario){
                PermisosUsuario::where('id',$permisoUsuario->id)->delete();
                //dump($permiso);
            }
        }

        return response()->json([
            "mensaje" => "permiso eliminado"
        ], 200);
    }
}
