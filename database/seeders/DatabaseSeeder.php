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
        \App\Models\Permiso::create(['tipo_permiso' => 'administrador']);
        \App\Models\Permiso::create(['tipo_permiso' => 'cliente']);
        \App\Models\Permiso::create(['tipo_permiso' => 'usuario_final']);

        \App\Models\TipoUsuario::create(['perfil' => 'publico']);
        \App\Models\TipoUsuario::create(['perfil' => 'profesor']);
        \App\Models\TipoUsuario::create(['perfil' => 'estudiante']);

        \App\Models\Administrador::create([
            'id' => 20202578024,
            'name' => 'nicolas rubio',
            'email' => 'nrubios@udistrital.edu.co',
            'password' => 'nicolas123', // password
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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
