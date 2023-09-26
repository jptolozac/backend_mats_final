<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function permiso(){
        return $this->belongsTo(Permiso::class);
    }
    public function TipoUsuario(){
        return $this->belongsTo(TipoUsuario::class);
    }

    public function consultarNoticias(String $busqueda, String $orden){
        
        $noticias = DB::select("select n.id, n.titulo, n.descripcion, IFNULL(ap.estado, 0) as apoyado, n.archivo, n.likes, DATE_FORMAT(n.created_at, '%Y-%m-%d') as fecha, tu.perfil
                            from noticias_tipos nt join tipo_usuarios tu on (nt.tipo_usuario_id = tu.id) 
                                                    join noticias n on (nt.noticia_id = n.id) 
                                                    join users us on (us.tipo_usuario_id = tu.id)
                                                    left join apoyos ap on (ap.user_id = us.id and ap.noticia_id = n.id)
                            where us.id = ? and (n.titulo like '%{$busqueda}%' or n.descripcion like '%{$busqueda}%') 
                            order by n.{$orden} desc", [$this->id]);
        
        return $noticias;
    }

    public function permisosUsuario(){
        return(
            $this->join('permisos_usuarios', 'users.id', '=', 'permisos_usuarios.user_id')
            ->join('permisos', 'permisos.id', '=', 'permisos_usuarios.permiso_id')
            ->select('permisos.id')
            ->where('users.email', $this->email)
            ->get()
        );
    }

    public function guardName(){
        return "user";
    }
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'tipo_usuario_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
