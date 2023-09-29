<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Permiso::create(['tipo_permiso' => 'noticias']);
        \App\Models\Permiso::create(['tipo_permiso' => 'preguntas_frecuentes']);
        \App\Models\Permiso::create(['tipo_permiso' => 'mesa_de_ayuda']);

        \App\Models\TipoUsuario::create(['perfil' => 'publico']);
        \App\Models\TipoUsuario::create(['perfil' => 'profesor']);
        \App\Models\TipoUsuario::create(['perfil' => 'estudiante']);

        \App\Models\Administrador::create([
            'id' => 20202578024,
            'name' => 'nicolas rubio',
            'email' => 'nrubios@udistrital.edu.co',
            'password' => 'nicolas123'
        ]);

        \App\Models\Administrador::create([
            'id' => 20201578009,
            'name' => 'Jean Paul',
            'email' => 'jptolozac@udistrital.edu.co',
            'password' => 'password', // password
        ]);

        \App\Models\User::factory(20)->create();

        \App\Models\Noticia::factory(100)->create();

        \App\Models\NoticiasTipo::factory(100)->create();

        \App\Models\Apoyo::factory(50)->create();

        \App\Models\Tarjeta::factory(100)->create();

        \App\Models\Categoria::factory(10)->create();   

        \App\Models\TarjetasUsuarios::factory(30)->create();

        \App\Models\TarjetasCategorias::factory(30)->create();

        \App\Models\Prioridad::create(['relevancia' => 'baja']);
        \App\Models\Prioridad::create(['relevancia' => 'media']);
        \App\Models\Prioridad::create(['relevancia' => 'alta']);

        \App\Models\CategoriaTK::factory(5)->create();

        \App\Models\Item::factory(10)->create();
        
        \App\Models\Estado::create(['nombre' => 'Pendiente']);
        \App\Models\Estado::create(['nombre' => 'En proceso']);
        \App\Models\Estado::create(['nombre' => 'Completada']);

        \App\Models\Comentario::factory(50)->create();

        \App\Models\Ticket::factory(100)->create();

        \App\Models\ComentariosTicket::factory(100)->create();  
        
        \App\Models\PermisosUsuario::factory(10)->create();

        \App\Models\Queja::factory(10)->create();


        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
