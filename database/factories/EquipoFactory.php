<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contratacion;
use App\Models\TipoEquipo;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipo>
 */
class EquipoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cod_interno' => fake()->text(100),
            'cod_externo' => fake()->text(100),
            'marca' => fake()->text(100),
            'modelo' => fake()->text(250),
            'product_number' => fake()->text(250),
            'num_serie' => fake()->text(100),
            'id_contratacion' => Contratacion::factory()->create()->id,
            'id_tipo_equipo' => TipoEquipo::factory()->create()->id,
        ];
    }
}
