<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        "asunto",
        "descripcion",
        "email_responsable",
        "email_responsable",
        "user_id",
        "categoria_id",
        "item_id",
        "estado_id",
        "prioridad_id",
    ];

    public static function TicketsUsuario(string | null $email, string | null $estado, string | null $prioridad, string | null $responsable){
        //dd($email, $estado, $prioridad);

        $sentencia = User::join('tickets', 'tickets.user_id', '=', 'users.id')
                        ->join('estados', 'tickets.estado_id', '=', 'estados.id')
                        ->select('tickets.id', 'tickets.user_id', 'tickets.categoria_id', 'tickets.item_id', 'tickets.asunto', 'tickets.descripcion', 'tickets.email_responsable', 'tickets.created_at', DB::raw('DATE(tickets.fecha_limite) as fecha_limite'), 'tickets.estado_id', 'tickets.prioridad_id', 'tickets.updated_at');
                        

       
        $responsable ? $sentencia->where('tickets.email_responsable', $responsable): null;
        
        $email ? $sentencia->where('users.email', "like", "%{$email}%") : null;
    

        

        ($estado) ? $sentencia->where('estados.id', $estado) : $sentencia->where(function (Builder $query) {
            $query->where('estados.nombre', 'Pendiente')
                ->orwhere('estados.nombre', 'En proceso');
        });

        ($prioridad) ? $sentencia->where('tickets.prioridad_id', $prioridad) : null;

        return ($sentencia->orderByDesc('tickets.updated_at')->get());
    }

    public static function nombreResponsable(string $email){
        /* $sentencia = Ticket::leftjoin('users', 'tickets.email_responsable', "=", "users.email")
                            ->leftjoin('administradors', 'administradors.email', "=", "tickets.email_responsable")
                            ->select(DB::raw('coalesce(users.email, administradors.email) as email'))
                            ->where('users.email', $email)
                            ->orWhere('administradors.email', $email)
                            ->groupby('email'); */

        $sentencia1 = User::select('id', 'name', 'email')
                            ->where('email', $email);

        $sentencia = Administrador::select('id', 'name', 'email')
                            ->where('email', $email)
                            ->union($sentencia1);

        return $sentencia->get();
    }
}
