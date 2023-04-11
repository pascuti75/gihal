<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ubicacion;

class UbicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ubicacion::create([
            'servicio' => 'Almacen',
            'dependencia' => 'Servicio',
            'direccion' => 'Direccion',
            'planta' => '',
            'created_at' => '2023-02-18 22:02:02',
            'updated_at' => '2023-02-18 22:02:02'
        ]);
    }
}
