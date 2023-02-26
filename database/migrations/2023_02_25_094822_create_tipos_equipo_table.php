<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tipos_equipo', function (Blueprint $table) {
           
            $table->id();
            //Código identificador único del tipo de equipo
            $table->string('cod_tipo_equipo', 3)->unique();
            //Denominación del tipo de equipo
            $table->string('tipo', 100);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_equipo');
    }
};
