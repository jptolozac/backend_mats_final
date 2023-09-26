<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
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
    public function show(string $ticket)
    {
        $comentarios = Comentario::join('comentarios_tickets', 'comentarios.id', '=', 'comentarios_tickets.comentario_id')
                            ->select('comentarios.id', 'comentarios.comentario', 'comentarios.created_at')
                            ->where('comentarios_tickets.ticket_id', $ticket)
                            ->get();
        return $comentarios;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comentario $comentario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comentario $comentario)
    {
        //
    }
}
