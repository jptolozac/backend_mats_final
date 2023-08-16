<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Tarjeta;
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
        return $tarjeta->getPreguntas(request()->tipoUsuario, request()->categoria);
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
    public function show(Tarjeta $tarjeta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarjeta $tarjeta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarjeta $tarjeta)
    {
        //
    }
}
