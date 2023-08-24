<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Categoria extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre"
    ];
    
    public static function getCategoriasUsuario(int $user){
        return DB::select("SELECT cat.id, cat.nombre
                        from tarjetas tj join tarjetas_categorias tjc on (tj.id = tjc.tarjeta_id)
                                        join categorias cat on (cat.id = tjc.categoria_id)
                        where tj.id = {$user}");
    }
}
