<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisosUsuario extends Model
{
    use HasFactory;

    public static $rules = [
        'permiso_id' => 'unique:permisos_usuarios,permiso_id,NULL,id,user_id,:user_id',
        'user_id' => 'unique:permisos_usuarios,user_id,NULL,id,permiso_id,:permiso_id'
    ];
}
