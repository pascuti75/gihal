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
        Schema::create('operaciones', function (Blueprint $table) {
            $table->id();
            //Tipo de operación aplicada al equipo
            $table->enum('tipo_operacion', ['instalacion', 'reparacion', 'almacenaje', 'baja']);
            //Fecha de realización de la operación
            $table->datetime('fecha_operacion');
            //Indica si es la ultima operacion activa para el equipo. Por defecto 'si' al crear
            $table->enum('activa', ['si', 'no'])->default('si');
            //FK. Identificador del equipo sobre el que se realiza la operación
            $table->foreignId('id_equipo')->references('id')->on('equipos');
            //FK. Identificador de la ubicación del equipo sobre el que se realiza la operación(opcional)
            $table->foreignId('id_ubicacion')->nullable()->references('id')->on('ubicaciones');
            //FK. Identificador de la persona beneficiada de la operación sobre el equipo (opcional)
            $table->foreignId('id_persona')->nullable()->references('id')->on('personas');
            //FK. Usuario (técnico) que realiza la operación (opcional)
            $table->foreignId('id_user')->nullable()->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operaciones');
    }
};
