<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tarjeta extends Model
{
    use HasFactory;

    protected $fillable = [
        "titulo",
        "descripcion"
    ];

    public function getPreguntas($tipoUsuario, $categoria){
        
        return (DB::select("SELECT tj.id, tj.titulo, tj.descripcion
                                from tarjetas tj join tarjetas_usuarios tju on (tj.id = tju.tarjeta_id)
                                                join tarjetas_categorias tjc on (tj.id = tjc.tarjeta_id)
                                                join tipo_usuarios tu on (tu.id = tju.tipo_id)
                                                join categorias cat on (cat.id = tjc.categoria_id) "
                                . ((isset($tipoUsuario) || isset($tipoUsuario)) ? "where " : "")
                                . ((!empty($tipoUsuario) && $tipoUsuario != "administrador") ? "(tu.perfil = '{$tipoUsuario}') or tu.perfil = 'publico' " : "")
                                . ((!empty($categoria)) ? "and cat.nombre = '{$categoria}' " : "" )
                                . "group by tj.id, tj.titulo, tj.descripcion;"));
    }
}
