<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contratacion>
 */
class ContratacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => fake()->title(500),
            'empresa' => fake()->text(250),
            'fecha_inicio' => fake()->date($format = 'Y-m-d'),
            'fecha_fin' => Carbon::instance(fake()->dateTimeBetween('fecha_inicio', '10 years'))->format('Y-m-d')
        ];
    }
}
