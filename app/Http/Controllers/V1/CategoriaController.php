<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CategoriaResource;
use App\Models\Categoria;
use App\Models\TarjetasCategorias;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(isset(request()->tarjeta) && !empty(request()->tarjeta)){
            $categorias = Categoria::getCategoriasUsuario(request()->tarjeta);
        }else{
            $categorias = Categoria::all();
        }
        return new CategoriaResource($categorias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $nombre = $request->validate([
            "nombre" => "required"
        ]);

        Categoria::create($nombre);
        
        return response()->json([
            "mensaje" => "Categoría creada correctamente"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $nombre = $request->validate([
            "nombre" => "required"
        ]);
        
        $categoria->nombre = $nombre["nombre"];

        $categoria->save();

        return response()->json([
            "mensaje" => "categoría editada correctamente"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        TarjetasCategorias::where("categoria_id", $categoria->id)->delete();

        $categoria->delete();

        response()->json([
            "mensaje" => "mensaje eliminado correctamente"
        ]);
    }
}
