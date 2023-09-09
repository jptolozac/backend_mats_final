<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Apoyo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApoyoController extends Controller
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
        $request->validate([
            'usuario' => 'required|email',
            'noticia' => 'required'
        ]);
        
        //Apoyo::crearApoyo($request->usuario, $request->noticia);

        $apoyo = new Apoyo();

        //dd($request->accion);

        if(isset($request->accion)){
            if($request->accion == 'agregar'){
                //dd($apoyo->consultarUsuario($request->usuario)[0]->id);
                $apoyo->user_id = ($apoyo->consultarUsuario($request->usuario)[0]->id);
                $apoyo->noticia_id = $request->noticia;
                $apoyo->estado = 1;

                $apoyo->save();

                DB::table('noticias')->where('id', $apoyo->noticia_id)
                                ->update(["likes" => DB::raw("likes + 1")]);

                return response()->json([
                    "mensaje" => "apoyo registrado"
                ]);
            }else if ($request->accion == 'eliminar'){
                $apoyo->where('user_id', '=', $apoyo->consultarUsuario($request->usuario)[0]->id)
                         ->where('noticia_id', '=', $request->noticia)
                         ->delete();
                
                DB::table('noticias')->where('id', $request->noticia)
                                ->update(["likes" => DB::raw("likes - 1")]);

                return response()->json([
                    "mensaje" => "apoyo eliminado"
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Apoyo $apoyo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apoyo $apoyo)
    { 
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apoyo $apoyo)
    {
        //
    }
}
