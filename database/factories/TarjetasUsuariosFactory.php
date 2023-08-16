<?php

namespace Database\Factories;

//use App\Models\TarjetasUsuarios;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TarjetasUsuarios>
 */
class TarjetasUsuariosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tarjeta = \App\Models\TarjetasUsuarios::select(["tarjeta_id", "tipo_id"])->get()->toArray();

        do{
            $valorTarjeta = rand(1, 100);
            $valorTipo = rand(1, 3);
            $valor = [
                "tarjeta_id" => $valorTarjeta, 
                "tipo_id" => $valorTipo
            ];
        }while(in_array($valor, $tarjeta));

        return [
            'tarjeta_id' => $valorTarjeta,
            'tipo_id' => $valorTipo
        ];
    }
}
