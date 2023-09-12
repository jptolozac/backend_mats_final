<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Auth;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = [];
        if(isset(request()->user) && !empty(request()->user && request()->user != "admin")){
            if((isset(request()->mostrar) && !empty(request()->mostrar))){
                $tickets = Ticket::TicketsUsuario(request()->user, request()->mostrar);
            }else{
                $tickets = Ticket::TicketsUsuario(request()->user, null);
            }
        }

        if(isset(request()->user) && !empty(request()->user) && request()->user == "admin"){
            $tickets = Ticket::TicketsUsuario(null, null);
        }

        if(isset(request()->responsable) && !empty(request()->responsable)){
            $responsable = Ticket::nombreResponsable(request()->responsable);
            return ((!empty($responsable[0])) ? $responsable[0] : ["mensaje" => "correo no encontrado"]);
        }

        return ([
            "data" => $tickets
        ]);
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
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
