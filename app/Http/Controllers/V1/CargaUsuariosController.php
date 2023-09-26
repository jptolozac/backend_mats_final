<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CargaUsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function cargarDatos(Request $request){
        if(\Auth::guard('sanctum')->user()->guardName() == "admin"){
            $file = $request->file('carga_usuarios');

            if($file && ($file->extension() == "csv")){
                $ruta = $file->getRealPath();
                $datos = array_map('str_getcsv', file($ruta));
                $usuarios = array_map(function ($dato){
                    return [
                        "name" => $dato[0],
                        "email" => $dato[1],
                        "password" => $dato[2],
                        "tipo_usuario_id" => (int)($dato[3]),
                    ];
                }, $datos);

                for($i = 1; $i < count($usuarios); $i++){
                    //return ($usuarios[$i]);
                    User::create($usuarios[$i]);
                }

                return response()->json([
                    "mensaje" => "Usuarios insertados correctamente"
                ]);

            }

            return response()->json([
                "mensaje" => "No se pudieron cargar los datos"
            ]);
        }

        return response()->json([
            "mensaje" => "usted no puede realizar la carga"
        ], 401);
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
