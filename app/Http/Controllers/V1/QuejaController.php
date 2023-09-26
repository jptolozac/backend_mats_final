<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Queja;
use Illuminate\Http\Request;

class QuejaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sentencia = Queja::select('id', 'asunto', 'descripcion', 'visto');

        isset(request()->estado) ? $sentencia->where("visto", request()->estado) : null;

        return ($sentencia->orderBy('updated_at', 'desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'asunto' => 'required|string',
            'descripcion' => 'required|string',
        ]);

        $queja = Queja::create($datos);

        return response()->json([
            "mensaje" => "Queja creado con exito"
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Queja $queja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Queja $queja)
    {
        $estado = (int)($request->estado);
        
        $queja->visto = $estado;
        $queja->save();
        
        return response()->json([
            "mensaje" => "estado de la queja cambiado"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Queja $queja)
    {
        //
    }
}
