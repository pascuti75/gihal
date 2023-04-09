<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

//Definicion de factory para modelo User
class UserFactory extends Factory
{

    public function definition(): array
    {
        return [
            'username' => fake()->name(255),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'es_administrador' => fake()->randomElement([0, 1]),
            'es_gestor' => fake()->randomElement([0, 1]),
            'es_tecnico' => fake()->randomElement([0, 1]),
            'es_consultor' => fake()->randomElement([0, 1]),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
