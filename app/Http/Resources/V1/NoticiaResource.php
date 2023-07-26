<?php

namespace App\Http\Resources\V1;

use App\Models\TipoUsuario;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class NoticiaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tipo_usuario' => $this->tipoUsuarios($this->id),
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'archivo' => $this->archivo,
            'likes' => $this->likes,
            'fecha' => Carbon::parse($this->created_at)->toDateString()
        ];
    }
}
