<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "nombre" => $this->nombre,
            "categoria" => \App\Models\CategoriaTK::select('id', 'nombre')
                                ->where('id', $this->categoria_id)
                                ->get()
                                ->toArray()[0]
        ];
    }
}
