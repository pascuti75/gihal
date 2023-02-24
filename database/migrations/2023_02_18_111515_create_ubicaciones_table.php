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
        Schema::create('ubicaciones', function (Blueprint $table) {
            $table->id();
            //Nombre del servicio situado en la ubicación
            $table->string('servicio', 250);
            //Nombre de la dependencia donde está situada la ubicación
            $table->string('dependencia', 250);
            //Dirección de la ubicación
            $table->string('direccion', 500);
            //Planta en la dependencia donde está alojada la ubicación (opcional)
            $table->string('planta', 30)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubicaciones');
    }
};
