<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\NoticiaResource;
use App\Models\Apoyo;
use App\Models\Noticia;
use App\Models\NoticiasTipo;
use Illuminate\Http\Request;
use App\Http\Resources\V1\NoticiaCollection;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $cantidadNoticias = 0;
    public function index(){
        $busqueda = isset(request()->buscar) ? request()->buscar : '';
        $cantidad = isset(request()->cantidad) ? request()->cantidad : $this->cantidadNoticias;
        
        return new NoticiaCollection((Noticia::BuscarNoticias($busqueda, $cantidad)));
    }

    public function cantidadNoticias(Request $request){
        $busqueda = isset($request->buscar) ? $request->buscar : '';
        $cantidad = isset($request->cantidad) ? $request->cantidad : $this->cantidadNoticias;

        $noticias = Noticia::BuscarNoticias($busqueda, $cantidad);

        return new NoticiaCollection($noticias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string',
            'descripcion' => 'required|string',
        ]);

        $noticia = Noticia::create($data);
        
        foreach($request->noticiaTipo as $tipo){
            $noticiaTipo = [
                "tipo_usuario_id" => $tipo,
                "noticia_id" => $noticia->id
            ];

            NoticiasTipo::create($noticiaTipo);
        }

        return response()->json([
            "mensaje" => "Noticia creada con éxtio",
            "noticia" => $noticia
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Noticia $noticia)
    {
        return new NoticiaResource($noticia);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Noticia $noticia)
    {
        $noticia->titulo = $request->titulo;
        //$noticia->fecha = $request->noticia->fecha;
        $noticia->descripcion = $request->descripcion;

        $noticia->save();

        NoticiasTipo::where('noticia_id', $noticia->id)->delete();
        //return $request->noticiaTipo;
        foreach($request->noticiaTipo as $tipo){
            $noticiaTipo = [
                "tipo_usuario_id" => $tipo,
                "noticia_id" => $noticia->id
            ];

            NoticiasTipo::create($noticiaTipo);
        }

        //dd($request->noticiaTipo);

        return response()->json([
            "mensaje" => "cambios guardados",
            "noticia" => $noticia
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Noticia $noticia)
    {
        $apoyos = Apoyo::where("noticia_id", $noticia->id)->delete();

        $noticiasTipos = NoticiasTipo::where("noticia_id", $noticia->id)->delete();

        $noticia->delete();

        return response()->json([
            "mensaje" => "se eliminó correctamente la noticia"
        ], 200);
    }
}
