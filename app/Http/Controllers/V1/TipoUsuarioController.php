<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TipoUsuarioResource;
use App\Models\TipoUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoUsuarioController extends Controller
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
    public function show(TipoUsuario $tipoUsuario)
    {
        //el atributo va segun el id del tipo de usuario: 1->coordinacion, 2->profesor, 3->estudiante
        //para ver la paginación, ir a TipoUsuarioResource en resources/V1/TipoUsuarioResource
        return new TipoUsuarioResource($tipoUsuario);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoUsuario $tipoUsuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoUsuario $tipoUsuario)
    {
        //
    }
}
