<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PermisosUsuario>
 */
class PermisosUsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'permiso_id' => $this->faker->numberBetween(1, 3),
            'user_id' => $this->faker->numberBetween(1, 20)
        ];
    }
}
