<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'password' => '$2y$10$Uj.GJw.w1RZeFc0VYRlKMe./qiWBMpcCjpBOwgIf1jTQ/GYbjBFc6',
            'es_administrador' => 1,
            'es_gestor' => 1,
            'es_tecnico' => 1,
            'es_consultor' => 1,
            'remember_token' => NULL,
            'created_at' => '2023-02-18 22:02:02',
            'updated_at' => '2023-02-18 22:02:02'
        ]);
    }
}
