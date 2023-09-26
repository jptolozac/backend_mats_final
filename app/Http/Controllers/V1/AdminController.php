<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Administrador;
use Illuminate\Http\Request;

class AdminController extends Controller
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
    public function show(string $email)
    {
        if(request()->accion == "buscarResponsable"){
            $responsable = Administrador::select('id', 'name', 'email')->where("email", $email)->get();
            $responsable = ($responsable->toArray() == []) ? \App\Models\User::select('id', 'name', 'email')->where("email", $email)->where('tipo_usuario_id', 2)->get() : $responsable;
            $mensaje = ($responsable->toArray() != []) ? $responsable[0] : null;
        }
        return response()->json([
            "responsable" => $mensaje
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Administrador $administrador)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Administrador $administrador)
    {
        //
    }
}
