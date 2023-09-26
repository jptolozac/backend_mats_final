<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ItemResource::collection(Item::select('id', 'nombre', 'categoria_id')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            "nombre" => 'required',
            "categoria_id" => 'required',
        ]);

        Item::create($datos);

        return response()->json([
            "mensaje" => "item creado"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return ($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $datos = $request->validate([
            "nombre" => 'required',
            "categoria_id" => 'required',
        ]);

        $item->nombre = $datos['nombre'];
        $item->categoria_id = $datos['categoria_id'];
        $item->save();

        return response()->json([
            "mensaje" => "item editado"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json([
            "mensaje" => "item eliminado"
        ]);
    }
}
