<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

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
                        order by n.updated_at desc", [$this->id]);
        
        return $noticias;
    }

    public function consultarNoticiasApoyo(String $busqueda, String $token){
        $accessToken = PersonalAccessToken::findToken($token);
    
        if ($accessToken) {
            $user = $accessToken->tokenable;
            
            $noticias = DB::select("select n.id, n.titulo, n.descripcion, IFNULL(ap.estado, 0) as apoyado, n.archivo, n.likes, DATE_FORMAT(n.created_at,        '%Y-%m-%d') as fecha, tu.perfil
                            from noticias_tipos nt join tipo_usuarios tu on (nt.tipo_usuario_id = tu.id) 
                                                    join noticias n on (nt.noticia_id = n.id) 
                                                    join users us on (us.tipo_usuario_id = tu.id)
                                                    left join apoyos ap on (ap.user_id = us.id and ap.noticia_id = n.id)
                            where us.id = ? and (n.titulo like '%{$busqueda}%' or n.descripcion like '%{$busqueda}%')
                            order by n.updated_at desc", [$user->id]);
            /* dd("select n.id, n.titulo, n.descripcion, IFNULL(ap.estado, 0) as apoyado, n.archivo, n.likes, DATE_FORMAT(n.created_at,        '%Y-%m-%d') as fecha, tu.perfil
            from noticias_tipos nt join tipo_usuarios tu on (nt.tipo_usuario_id = tu.id) 
                                    join noticias n on (nt.noticia_id = n.id) 
                                    join users us on (us.tipo_usuario_id = tu.id)
                                    left join apoyos ap on (ap.user_id = us.id and ap.noticia_id = n.id)
            where us.id = {$user->id} and (n.titulo like '%{$busqueda}%' or n.descripcion like '%{$busqueda}%')
            order by n.updated_at desc"); */
            return $noticias;
        }
        
        return response()->json([
            "mensaje" => "token nulo"
        ]);
    }
}
