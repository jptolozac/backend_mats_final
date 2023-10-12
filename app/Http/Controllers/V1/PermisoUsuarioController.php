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
                            ->where('permisos_usuarios.permiso_id', 1)
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
        if(request()->permiso == 'mesa_ayuda'){
            $usuario = \App\Models\User::where('email', $email)->get();
            if(count($usuario) > 0) {
                $clase = \App\Models\User::class;
                $tabla = 'users';
            }else{ 
                $clase = \App\Models\Administrador::class;
                $usuario = $clase::where('email', $email)->get();
                $tabla = 'administradors';
            } 
            
            $ticketsAsignadosUser = $clase::join('tickets', "{$tabla}.email", '=', 'tickets.email_responsable')
                ->where('email', $email)
                ->where('estado_id', '!=', 3)
                ->get()
                ->toArray();

            if((count($ticketsAsignadosUser) > 0)){
                return response()->json([
                    "mensaje" => "tickets pendientes"
                ]);
            }
            if($tabla != 'administradors'){
                PermisosUsuario::where('user_id', $usuario[0]->id)
                    ->where('permiso_id', 3)
                    ->delete();
            }
        }

        return response()->json([
            "mensaje" => "permiso eliminado"
        ], 200);
    }
}
;