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

    public function getPreguntas($tipoUsuario, $categorias, $buscar){
        $consulta = "SELECT tj.id, tj.titulo, tj.descripcion
        from tarjetas tj join tarjetas_usuarios tju on (tj.id = tju.tarjeta_id)
                        join tarjetas_categorias tjc on (tj.id = tjc.tarjeta_id)
                        join tipo_usuarios tu on (tu.id = tju.tipo_id)
                        join categorias cat on (cat.id = tjc.categoria_id) "
        . (((isset($tipoUsuario) && $tipoUsuario != "administrador") || (isset($categorias)) || (isset($buscar))) ? "\nwhere " : "")
        . ((!empty($tipoUsuario) && $tipoUsuario != "administrador") ? "(tu.perfil = '{$tipoUsuario}' or tu.perfil = 'publico') " : "");

        $consulta .= (!empty($tipoUsuario) && $tipoUsuario != "administrador" && (isset($categorias) || isset($buscar))) ? "and " : "";
        $ti = true;
        if($categorias != null){
            $consulta .= "(";
            foreach($categorias as $categoria){
                if($ti){
                    $consulta .= "cat.id = " . $categoria;
                    $ti = false;
                }else{
                    $consulta .= " or cat.id = " . $categoria;
                }
            }
            $consulta .= ")";
        }

        if($buscar != null){
            $consulta .= ((!$ti) ? " and " : " ");
            $consulta .= "(tj.titulo like '%{$buscar}%' or tj.descripcion like '%{$buscar}%')";
        }
        
        $consulta .= "\ngroup by tj.id, tj.titulo, tj.descripcion;";
        //dd($consulta);

        //dd($consulta);

        return (DB::select($consulta));
    }
}
