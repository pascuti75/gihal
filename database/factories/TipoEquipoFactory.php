<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipoEquipo>
 */
class TipoEquipoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return  [
            'cod_tipo_equipo' => fake()->unique()->regexify('[A-Za-z0-9]{3}'),
            'tipo' => fake()->text(100)
        ];
    }
}
