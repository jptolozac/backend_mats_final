<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class TipoUsuario extends Model
{
    use HasFactory;

    public function user(){
        return $this->hasMany(User::class);
    }
    /* public function noticiaTipo(){
        return $this->belongsTo(User::class);
    } */

    public function noticias(){
        //return $this->hasManyThrough(Noticia::class, NoticiaTipo::class);
        return $this->BelongsToMany(Noticia::class, 'noticias_tipos');
    }

    public function consultarNoticias(String $busqueda){
        $noticias = DB::select("select n.id, n.titulo, n.descripcion, n.archivo, n.likes, DATE_FORMAT(n.created_at, '%Y-%m-%d') as fecha
                        from noticias_tipos nt join tipo_usuarios tu on (nt.tipo_usuario_id = tu.id) 
                                            join noticias n on (nt.noticia_id = n.id) 
                        where tu.id = ? and (n.titulo like '%{$busqueda}%' or n.descripcion like '%{$busqueda}%') 
                        order by n.created_at asc", [$this->id]);
        
        return $noticias;
    }
}
