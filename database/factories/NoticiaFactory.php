<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Noticia>
 */
class NoticiaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->sentence(),
            'descripcion' => $this->faker->text(1600),
            'likes' => $this->faker->numberBetween(0, 5000),
            'archivo' => "TsZKYB4QrcfHqdqav3GQaGOPWT1jGURobXHCHJiU.pdf"
        ];
    }
}
