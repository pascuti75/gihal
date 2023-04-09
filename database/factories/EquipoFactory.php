<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contratacion;
use App\Models\TipoEquipo;

//Definicion de factory para modelo Equipo
class EquipoFactory extends Factory
{
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
