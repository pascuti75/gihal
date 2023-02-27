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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            //Código identificador del equipo segun la administración local (opcional)
            $table->string('cod_interno', 100)->nullable();
            //Código identificador del equipo segun la empresa licitadora (opcional)
            $table->string('cod_externo', 100)->nullable();
            //Marca del equipo
            $table->string('marca', 100);
            //Modelo del equipo
            $table->string('modelo', 250);
            //Product number del equipo (opcional)
            $table->string('product_number', 250)->nullable();
            //Número de serie del equipo
            $table->string('num_serie', 100);
            //FK. Identificador de la contratación asociada al equipo (opcional)
            $table->foreignId('id_contratacion')->nullable()->references('id')->on('contrataciones');
            //FK. Identificador del tipo de equipo',
            $table->foreignId('id_tipo_equipo')->references('id')->on('tipos_equipo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
