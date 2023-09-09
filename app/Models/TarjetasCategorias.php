<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarjetasCategorias extends Model
{
    use HasFactory;

    protected $fillable = [
        "tarjeta_id",
        "categoria_id"
    ];

    public static $rules = [
        'tarjeta_id' => 'unique:tarjetas_categorias,tarjeta_id,NULL,id,categoria_id,:categoria_id',
        'categoria_id' => 'unique:tarjetas_categorias,categoria_id,NULL,id,tarjeta_id,:tarjeta_id'
    ];


    public static function eliminarTarjetaCategorias($tarjeta){
        return TarjetasCategorias::where('tarjeta_id', $tarjeta)->delete();
    }
    
}
