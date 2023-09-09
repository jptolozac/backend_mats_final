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
        return [
            'tarjeta_id' => $this->faker->numberBetween(1, 100),
            'tipo_id' => $this->faker->numberBetween(1, 3)
        ];
    }
}
