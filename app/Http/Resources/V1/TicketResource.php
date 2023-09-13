<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = \App\Models\User::select('id', 'name', 'email')->find($this->user_id);
        $categoria = \App\Models\Categoria::select('id', 'nombre')->find($this->categoria_id);
        $item = \App\Models\Item::select('id', 'nombre')->find($this->item_id);
        $estado = \App\Models\Estado::select('id', 'nombre')->find($this->estado_id);
        $prioridad = \App\Models\Prioridad::select('id', 'relevancia')->find($this->prioridad_id);
        $responsable = \App\Models\Ticket::nombreResponsable($this->email_responsable)[0];
        return [
            "id" => $this->id,
            "asunto" => $this->asunto,
            "descripcion" => $this->descripcion,
            "usuario" => $user,
            "categoria" => $categoria,
            "item" => $item,
            "estado" => $estado,
            "prioridad" => $prioridad,
            "responsable" => $responsable,
            "created_at" => $this->created_at,
            "fecha_limite" => $this->fecha_limite,
            "updated_at" => $this->updated_at
        ];
    }
}
