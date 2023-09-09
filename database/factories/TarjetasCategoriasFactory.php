<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TarjetasCategorias>
 */
class TarjetasCategoriasFactory extends Factory
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
            'categoria_id' => $this->faker->numberBetween(1, 10)
        ];
    }
}
