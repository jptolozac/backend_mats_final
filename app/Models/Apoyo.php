<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Apoyo extends Model
{
    use HasFactory;

    public function crearApoyo(string $usuario, string $noticia){
        return DB::update("insert into apoyos (user_id, noticia_id, estado)
        SELECT id, {$noticia}, 1
        from users u
        where email = '$usuario';");
    }

    public function consultarUsuario(string $email){
        return DB::select("select id
                           from users
                           where email = '{$email}'");
    }
    //algo
}
