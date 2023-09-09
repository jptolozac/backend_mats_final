<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarjetasUsuarios extends Model
{
    use HasFactory;

    protected $fillable = [
        "tarjeta_id",
        "tipo_id"
    ];

    public static $rules = [
        'tarjeta_id' => 'unique:tarjetas_usuarios,tarjeta_id,NULL,id,tipo_id,:tipo_id',
        'tipo_id' => 'unique:tarjetas_usuarios,tipo_id,NULL,id,tarjeta_id,:tarjeta_id',
    ];


    public static function getUsuariosTarjeta($tarjeta){
        return TarjetasUsuarios::select('tipo_id')
                        ->where('tarjeta_id', $tarjeta->id)
                        ->where('tipo_id', '!=', '1')
                        ->get();
    }

    public static function eliminarTarjetaUsuarios($tarjeta){
        return TarjetasUsuarios::where('tarjeta_id', $tarjeta)->delete();
    }
}
