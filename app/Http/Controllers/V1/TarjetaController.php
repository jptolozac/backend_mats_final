<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Tarjeta;
use App\Models\TarjetasCategorias;
use App\Models\TarjetasUsuarios;
use Illuminate\Http\Request;

class TarjetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /* $tipoUsuario = isset(request()->tipoUsuario) ? request()->tipoUsuario : null;
        $categoria = isset(request()->categoria) ? request()->categoria : null;
        dump($tipoUsuario);
        dd($categoria); */

        $tarjeta = new Tarjeta();
        $categorias = explode(",",request()->categorias);
        $categorias = ($categorias == [""]) ? null : $categorias;
        
        if($categorias != null && $categorias[count($categorias)-1] == "")
            unset($categorias[count($categorias)-1]);

        return $tarjeta->getPreguntas(request()->tipoUsuario, $categorias, request()->buscar);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tarjetaREl = $request->validate([
            "titulo" => 'required',
            "descripcion" => 'required',
            "usuarios" => 'required',
            "categorias" => 'required',
        ]);
        $tarjetaNew['titulo'] = $tarjetaREl['titulo'];
        $tarjetaNew['descripcion'] = $tarjetaREl['descripcion'];
        $tarjeta = Tarjeta::create($tarjetaNew);

        foreach($tarjetaREl['usuarios'] as $usuario){
            $data = [
                "tarjeta_id" => $tarjeta->id,
                "tipo_id" => $usuario
            ];
            TarjetasUsuarios::create($data);
        }

        foreach($tarjetaREl['categorias'] as $categoria){
            $data = [
                "tarjeta_id" => $tarjeta->id,
                "categoria_id" => $categoria
            ];
            TarjetasCategorias::create($data);
        }

        return response()->json([
            "mensaje" => "Se creó la tarjeta con éxito"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarjeta $tarjeta)
    {
        $busqueda = TarjetasUsuarios::getUsuariosTarjeta($tarjeta);
        $usuariosTarjeta = [];
        foreach($busqueda as $tipo){
            array_push($usuariosTarjeta, $tipo->tipo_id);
        }
        return $usuariosTarjeta;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarjeta $tarjeta)
    {
        TarjetasUsuarios::eliminarTarjetaUsuarios($tarjeta->id);
        TarjetasCategorias::eliminarTarjetaCategorias($tarjeta->id);

        $tarjeta->titulo = $request->titulo;
        $tarjeta->descripcion = $request->descripcion;
        $tarjeta->save();

        foreach($request->usuarios as $usuario){
            $data = [
                "tarjeta_id" => $tarjeta->id,
                "tipo_id" => $usuario
            ];
            TarjetasUsuarios::create($data);
        }

        foreach($request->categorias as $categoria){
            $data = [
                "tarjeta_id" => $tarjeta->id,
                "categoria_id" => $categoria
            ];
            TarjetasCategorias::create($data);
        }

        return response()->json([
            "mensaje" => "Se editó la tarjeta con éxito"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarjeta $tarjeta)
    {
        TarjetasUsuarios::eliminarTarjetaUsuarios($tarjeta->id);
        TarjetasCategorias::eliminarTarjetaCategorias($tarjeta->id);

        $tarjeta->delete();

        return response()->json([
            "mensaje" => "Tarjeta eliminada correctamente"
        ], 200);
    }
}
