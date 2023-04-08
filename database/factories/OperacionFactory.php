<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Equipo;
use App\Models\TipoEquipo;
use App\Models\Ubicacion;
use App\Models\Persona;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Operacion>
 */
class OperacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipo_operacion' => fake()->randomElement(['instalacion', 'reparacion', 'almacenaje', 'baja']),
            'fecha_operacion' => fake()->dateTimeBetween('-1 year', 'now'),
            'activa' => fake()->randomElement(['si', 'no']),
            'id_equipo' => Equipo::factory()->create()->id,
            'id_ubicacion' => Ubicacion::factory()->create()->id,
            'id_persona' => Persona::factory()->create()->id,
            'id_user' => User::factory()->create(['es_tecnico' => 1])->id,
        ];
    }
}
