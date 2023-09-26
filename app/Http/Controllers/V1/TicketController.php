<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TicketCollection;
use App\Http\Resources\V1\TicketResource;
use App\Models\Comentario;
use App\Models\ComentariosTicket;
use App\Models\Ticket;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\Sanctum;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = [];
        $user = ((request()->user == "admin") ? null : request()->user);
        $estado = request()->estado;
        $prioridad = request()->prioridad;
        $responsable = request()->responsable;

        $tickets = Ticket::TicketsUsuario($user, $estado, $prioridad, $responsable);
        

        /* if(isset(request()->responsable) && !empty(request()->responsable)){
            $tickets = Ticket::TicketsUsuario($user, $estado, $prioridad, request()->responsable);

            $responsable = Ticket::nombreResponsable(request()->responsable);
            dd($responsable);
            return ((!empty($responsable[0])) ? $responsable[0] : ["mensaje" => "correo no encontrado"]);
        } */

        return new TicketCollection($tickets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            "asunto" => "required",
            "descripcion" => "required",
            "usuario" => "required|email",
            "categoria" => "required|numeric",
            "item" => "required|numeric",
        ]);

        $datos["email_responsable"] = "nrubios@udistrital.edu.co";
        $datos['user_id'] = (\App\Models\User::select('id')->where('email', $datos['usuario'])->get()[0]->id);
        unset($datos['usuario']);
        $datos['categoria_id'] = $datos['categoria'];
        unset($datos['categoria']);
        $datos['item_id'] = $datos['item'];
        unset($datos['item']);
        $datos['estado_id'] = 1;

        //dd($datos);
        Ticket::create($datos);

        return response()->json([
            "mensaje" => "ticket creado con exito"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        if($request->actualizar == 'responsable'){
            $email = $request->validate([
                'email' => 'required|email'
            ]);
            $ticket->email_responsable = $email['email'];
            $ticket->save();
            return response()->json([
                "mensaje" => "responsable actualizado"
            ]);
        }
        if($request->actualizar == "ticket"){
            $datos = $request->validate([
                'asunto' => 'required',
                'descripcion' => 'required',
                'email_responsable' => 'required',
                'categoria_id' => 'required',
                'item_id' => 'required',
                'estado_id' => 'required',
                'prioridad_id' => 'required'
            ]);
            $ticket->asunto = $datos['asunto'];
            $ticket->descripcion = $datos['descripcion'];
            $ticket->email_responsable = $datos['email_responsable'];
            $ticket->categoria_id = $datos['categoria_id'];
            $ticket->item_id = $datos['item_id'];
            $ticket->estado_id = $datos['estado_id'];
            $ticket->prioridad_id = $datos['prioridad_id'];
            $fechaCreacion = Carbon::parse($ticket->created_at)->tz('America/Bogota');
            
            switch($datos['prioridad_id']){
                case 1: $ticket->fecha_limite = $this->calcularFechaLimite(15, $fechaCreacion); break;
                case 2: $ticket->fecha_limite = $this->calcularFechaLimite(7, $fechaCreacion); break;
                case 3: $ticket->fecha_limite = $this->calcularFechaLimite(3, $fechaCreacion); break;
                default: return response()->json(["mensaje" => "prioridad inválida"], 400);
            }

            $ticket->save();
            if(isset($request->comentarios)){
                Comentario::join('comentarios_tickets', 'comentarios.id', '=', 'comentarios_tickets.comentario_id')
                                    ->where('comentarios_tickets.ticket_id', $ticket->id)
                                    ->delete();

                if(!empty($request->comentarios)){
                    foreach($request->comentarios as $comentario){
                        if(isset($comentario['comentario'])){
                            $comentarioNuevo = [
                                "comentario" => $comentario['comentario'] 
                            ];
                            
                            $coment = Comentario::create($comentarioNuevo);
                            $nuevoRegistro = [
                                'comentario_id' => $coment->id,
                                'ticket_id'=> $ticket->id
                            ];
                            ComentariosTicket::create($nuevoRegistro);
                        }
                    }
                }
            }
            

            return response()->json([
                "mensaje" => "ticket editado"
            ], 200);
        }
        
    }

    public function calcularFechaLimite(int $diasHabiles, Carbon $fecha){

        while(($diasHabiles - 1) > 0){ //se cuenta el día actual
            $fecha->addDay();

            if($fecha->isWeekday()){
                $diasHabiles--;
            }
        }

        return $fecha->toDateString();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        Comentario::join('comentarios_tickets', 'comentarios.id', '=', 'comentarios_tickets.comentario_id')
                ->where('comentarios_tickets.ticket_id', $ticket->id)
                ->delete();

        $ticket->delete();

        if($ticket){
            return response()->json([
                "mensaje" => "ticket eliminado con éxito"
            ]);
        }
        return response()->json([
            "mensaje" => "no se logró eliminar el ticket"
        ]);
    }
}
