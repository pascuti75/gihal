<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

//Definicion de factory para modelo Persona
class PersonaFactory extends Factory
{
    
    public function definition(): array
    {
        return [
            'nombre' => fake()->firstName(100),
            'apellidos' => fake()->lastName(100),
            'tipo_personal' => fake()->randomElement(['interno','externo'])
        ];
    }
}


