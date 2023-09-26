<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentariosTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'comentario_id',
        'ticket_id'
    ];

    public static $rules = [
        'comentario_id' => 'unique:comentarios_tickets,comentario_id,NULL,id,ticket_id,:ticket_id',
        'ticket_id' => 'unique:comentarios_tickets,ticket_id,NULL,id,comentario_id,:comentario_id'
    ];
}
