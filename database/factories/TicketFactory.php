<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do{
            $categoria = rand(1, 5);
            $consulta = \App\Models\Item::where('categoria_id', $categoria)->get()->toArray();
            $item = (count($consulta) > 0) ? $consulta[rand(0, count($consulta)-1)] : null;
        }while(!$item);

        $email = "";
        if((rand(false, true))){
            $admins = ['20201578009', '20202578024'];
            $random = $admins[rand(0,1)];
            $email = (\App\Models\Administrador::find($random)->email);
        }else{
            $random = rand(1, 20);
            $profesores = (\App\Models\User::where('tipo_usuario_id', 2)->get());
            $email = ($profesores[rand(0, count($profesores) - 1)])->email;
        }
        
        $prioridad = rand(1, 3);
        $fecha_limite = '';
        switch($prioridad){
            case 1: $fecha_limite = $this->calcularFechaLimite(15); break;
            case 2: $fecha_limite = $this->calcularFechaLimite(7); break;
            case 3: $fecha_limite = $this->calcularFechaLimite(3); break;
        }

        return [
            "asunto" => fake()->sentence(),
            "descripcion" => fake()->text(),
            "email_responsable" => $email,
            "fecha_limite" => $fecha_limite,
            "user_id" => rand(1, 10),
            "categoria_id" => $categoria,
            "item_id" => $item["id"],
            "estado_id" => rand(1, 3),
            "prioridad_id" => $prioridad
        ];
    }

    public function calcularFechaLimite(int $diasHabiles){
        $fecha = \Illuminate\Support\Carbon::now()->tz('America/Bogota');

        while(($diasHabiles - 1) > 0){ //se cuenta el día actual
            $fecha->addDay();

            if($fecha->isWeekday()){
                $diasHabiles--;
            }
        }

        return $fecha->toDateString();
    }
}
