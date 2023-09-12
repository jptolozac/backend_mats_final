<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //dd($this->id);

        if($request->noticias == "true"){
            $busqueda = isset($request->buscar) ? $request->buscar : "";
            $orden = ($request->orden == "likes") ? "likes" : "updated_at";
            $buscar = (isset($request->buscar) && !empty($request->buscar)) ? $request->buscar : "";
            $noticias = $this->consultarNoticias($buscar, $orden);

            return [
                'id' => $this->id,
                'nombre' => $this->name,
                'email' => $this->email,
                'noticias' => $noticias
            ];
        }
        
        return [
            'id' => $this->id,
            'nombre' => $this->name,
            'email' => $this->email
        ];
    }
}
