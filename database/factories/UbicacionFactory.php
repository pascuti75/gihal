<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

//Definicion de factory para modelo Ubicacion
class UbicacionFactory extends Factory
{    
    public function definition(): array
    {
        return [
            'servicio' => fake()->text(200),
            'dependencia' => fake()->text(200),
            'direccion' => fake()->text(200),
            'planta' => fake()->randomElement(['sotano','1','2','3','4','5','6','7']),
        ];
    }
}
