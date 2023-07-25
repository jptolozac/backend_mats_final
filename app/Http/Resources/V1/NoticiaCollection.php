<?php

namespace App\Http\Resources\V1;

use App\Models\Noticia;
use App\Models\TipoUsuario;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NoticiaCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array{
        return [
            'data' => $this->collection
        ];
    }
}
