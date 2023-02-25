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
        Schema::create('contrataciones', function (Blueprint $table) {
            $table->id();

            //Titulo para describir la contratación o licitación
            $table->string('titulo', 500);
            //Empresa que va a realizar la contratacion o licitación
            $table->string('empresa', 250);
            //Fecha de inicio del arrendamiento de los equipos (opcional)
            $table->date('fecha_inicio')->nullable();;
            //Fecha final del arrendamiento de los equipos (opcional)
            $table->date('fecha_fin')->nullable();;

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrataciones');
    }
};
