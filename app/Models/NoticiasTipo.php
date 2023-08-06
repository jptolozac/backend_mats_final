<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticiasTipo extends Model
{
    protected $fillable = [
        "tipo_usuario_id", 
        "noticia_id"
    ];
    use HasFactory;

    public function tipoUsuario(){
        return $this->belongsTo(TipoUsuario::class);
    }
    public function noticia(){
        return $this->belongsTo(Noticia::class);
    }

    /* public function consultarNoticias($idTipo){
        $noticias = DB::select('select n.titulo, n.descripcion, n.likes from noticias_tipos nt join tipo_usuarios tu on (nt.tipo_usuario_id = tu.id) join noticias n on (nt.noticia_id = n.id) where tu.id = ?', $idTipo);
        return $noticias;
    } */

    public function consultarTiposNoticia(int $tipo_usuario_id, int $noticia_id){
        return $this->where('tipo_usuario_id', '=', $tipo_usuario_id)
                    ->where('noticia_id', '=', $noticia_id)
                    ->get();
    }


}
