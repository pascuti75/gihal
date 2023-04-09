<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

//Definicion de factory para modelo Contratacion
class ContratacionFactory extends Factory
{ 
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
