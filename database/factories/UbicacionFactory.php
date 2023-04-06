<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ubicacion>
 */
class UbicacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'servicio' => fake()->text(250),
            'dependencia' => fake()->text(250),
            'direccion' => fake()->address(500),
            'planta' => fake()->randomElement(['sotano','1','2','3','4','5','6','7']),
        ];
    }
}
