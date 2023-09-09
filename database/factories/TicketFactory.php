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
        return [
            "asunto" => fake()->sentence(),
            "descripcion" => fake()->text(),
            "email_responsable" => fake()->email(),
            "fecha_limite" => fake()->dateTime(),
            "user_id" => rand(1, 10),
            "categoria_id" => rand(1, 5),
            "estado_id" => rand(1, 2),
            "prioridad_id" => rand(1, 3),
        ];
    }
}
