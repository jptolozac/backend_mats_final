<?php

namespace App\Http\Resources\V1;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TipoUsuarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //aqui voy
        //toca hacer este usuario resource con los de coordinador y profesor para mostrar las noticias para cada tipo de usuario
        
        $page = $request->query('page', 1);

        $perPage = 20;

        $busqueda = isset($request->buscar) ? $request->buscar : "";
        
        if(isset($request->usuario)){
            $shows = $this->consultarNoticiasApoyo($busqueda, $request->usuario);
        }else{
            $shows = $this->consultarNoticias($busqueda);
        }

        $collection = collect($shows);

        $paginatedShows = new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()]
        );

        $noticias = $paginatedShows->items();

        return [
            'id' => $this->id,
            'perfil' => $this->perfil,
            'noticias' => $shows
        ];

        //link demo con paginacion http://localhost:8000/api/v1/tipo_usuario/1?page=3
        //link demo sin paginacion http://localhost:8000/api/v1/tipo_usuario/1
    }
}
