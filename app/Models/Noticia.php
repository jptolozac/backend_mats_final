<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;


class Noticia extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'likes'
    ];

    /* public function noticiaTipo(){
        return $this->BelongsTo(NoticiaTipo::class);
    } */

    public function tipoUsuarios($id){
        //return $this->hasManyThrough(TipoUsuario::class, NoticiaTipo::class);
        //return $this->BelongsToMany(TipoUsuario::class, 'noticias_tipos');
        $consulta = DB::select('SELECT tu.perfil FROM noticias_tipos nt join tipo_usuarios tu on (tu.id = nt.tipo_usuario_id)join noticias n on (n.id = nt.noticia_id) where n.id = ?', [$id]);

        $array = [];

        foreach($consulta as $con){
            array_push($array, $con->perfil);
        }

        return $array;
    }

    public static function BuscarNoticias(String $busqueda, int $cantidad){
        $orden = request()->orden == "likes" ? "likes" : "updated_at";
        if($cantidad == 0){
            return Noticia::where("titulo", "like", "%{$busqueda}%")
            ->orwhere("descripcion", "like", "%{$busqueda}%")
            ->orderBy($orden, "desc")
            ->get();
        }
        return (Noticia::where("titulo", "like", "%{$busqueda}%")
        ->orwhere("descripcion", "like", "%{$busqueda}%")
        ->orderBy($orden, "desc")
        ->paginate($cantidad));
    }
}
