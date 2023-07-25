<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticiasTipo extends Model
{
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


}
