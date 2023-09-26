<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\CategoriaTK;
use Illuminate\Http\Request;

class CategoriaTKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CategoriaTK::select('id', 'nombre')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dato = $request->validate([
            "nombre" => "required"
        ]);

        CategoriaTK::create($dato);

        return response()->json([
            "mensaje" => "categoría creada"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $categoriaTK)
    {
        return CategoriaTK::find($categoriaTK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $categoriaTK)
    {
        $categoriaTK = CategoriaTK::find($categoriaTK);

        $dato = $request->validate([
            "nombre" => "required"
        ]);

        $categoriaTK->nombre = $dato['nombre'];
        $categoriaTK->save();
        
        return response()->json([
            "mensaje" => "categoría actualizada"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $categoriaTK)
    {
        $categoriaTK = CategoriaTK::find($categoriaTK);

        $categoriaTK->delete();

        return response()->json([
            'mensaje' => 'categoría eliminada'
        ]);
    }
}
