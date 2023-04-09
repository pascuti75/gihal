<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

//Definicion de factory para modelo TipoEquipo
class TipoEquipoFactory extends Factory
{
    
    public function definition(): array
    {
        return  [
            'cod_tipo_equipo' => fake()->unique()->regexify('[A-Za-z0-9]{3}'),
            'tipo' => fake()->text(100)
        ];
    }
}
