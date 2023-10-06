<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use App\Models\Administrador;
use App\Models\PermisosUsuario;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();
        return new UserResource($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::guard('sanctum')->user()->guardName() == "admin"){
            $datos = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'tipo_usuario_id' => 'required'
            ]);

            if($datos['tipo_usuario_id'] == 'null' || $datos['tipo_usuario_id'] == 4){
                Administrador::create($datos);
            }else{
                User::create($datos);
            }

            return response()->json([
                "mensaje" => "usuario creado"
            ]);
        }
        
        return response()->json([
            "mensaje" => "no se puede crear el usuario"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user)
    {
        return (!empty(User::where('email', $user)->get()->toArray())) ? User::where('email', $user)->get()->toArray() : Administrador::where('email', $user)->get()->toArray();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $user)
    {
        //dd(Auth::guard('sanctum')->user()->guardName(), $request->user());
        $mensaje = "";

        if($request->actualizar == 'password'){
            //dd($request->user());
            $this->actualizarPassword($request, $request->user());

            $mensaje = "contraseña actualizada con éxito";

        }else if($request->actualizar == 'usuario'){
            if(Auth::guard('sanctum')->user()->guardName() == "admin"){
                
                if($request->tipo_usuario_id == 'null' || $request->tipo_usuario_id == 4){
                    
                    $datos = $request->validate([
                        "name" => 'required',
                        "email" => 'required'
                    ]);

                    $usuario = Administrador::find($user);
                    if(!$usuario){
                        $usuario = User::find($user);
                        if(!$usuario){
                            return response()->json([
                                "mensaje" => "no se pudo encontrar el usuario"
                            ], 404);
                        }
                        $usuario->delete();
                        $usuario = Administrador::create([
                            'id' => $user,
                            "name" => $datos['name'],
                            "email" => $datos['email'],
                            "password" => "",
                        ]);
                    }
    
                    $usuario->update([
                        "name" => $datos['name'],
                        "email" => $datos['email']
                    ]);
                }else{
                    $datos = $request->validate([
                        "name" => 'required',
                        "email" => 'required',
                        "tipo_usuario_id" => 'required',
                        "permisos" => 'required',
                    ]);

                    $usuario = User::find($user);
                    if(!$usuario){
                        $usuario = Administrador::find($user);
                        if(!$usuario){
                            return response()->json([
                                "mensaje" => "no se pudo encontrar el usuario"
                            ], 404);
                        }
                        $usuario->delete();
                        $usuario = User::create([
                            'id' => $user,
                            "name" => $datos['name'],
                            "email" => $datos['email'],
                            "tipo_usuario_id" => $datos['tipo_usuario_id'],
                            "password" => "",
                        ]);
                    }else{
                        $usuario->update([
                            "name" => $datos['name'],
                            "email" => $datos['email']
                        ]);

                        $usuario->tipo_usuario_id = $datos['tipo_usuario_id'];
                        $usuario->save();
                    }
    
                    

                    //dd($usuario);

                    PermisosUsuario::where('user_id', $usuario->id)->delete();
                    
                    ($datos['permisos']['noticias']) ? PermisosUsuario::create(['permiso_id' => 1, 'user_id' => $usuario->id]) : null;
                    ($datos['permisos']['preguntas']) ? PermisosUsuario::create(['permiso_id' => 2, 'user_id' => $usuario->id]) : null;
                    ($datos['permisos']['mesaAyuda']) ? PermisosUsuario::create(['permiso_id' => 3, 'user_id' => $usuario->id]) : null;
                }
                
                //dd($usuario);

                
                if(isset($request->password) && !empty($request->password)){
                    $this->actualizarPassword($request, $usuario);
                    //dd($usuario);
                }
                
                $mensaje = "usuario actualizado";
            }else{
                
                return response()->json([
                    "mensaje" => "No tiene permisos para modificar usuarios"
                ], 401);
            }
        }else if($user == "modificar"){
            $datos = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
            ]);

            $usuario = $request->user();

            $usuario->name = $datos['name'];
            $usuario->email = $datos['email'];
            $usuario->save();
            
            $mensaje = "usuario actualizado";
        }

        return response()->json([
            "mensaje" => $mensaje
        ], 200);
    }

    public function actualizarPassword(Request $request, $usuario){
        $password = $request->validate([
            "password" => 'required'
        ]);
        //dd(/* $usuario,  */$password['password']);

        //$usuario = $request->user();

        $usuario->update([
            "password" => $password['password']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if($user){
            $user->delete();

            return response()->json([
                "mensaje" => "usuario eliminado"
            ]);
        }

        return response()->json([
            "mensaje" => "usuario no encontrado"
        ]);
    }
}
