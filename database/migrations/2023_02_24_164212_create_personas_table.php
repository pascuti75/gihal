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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();

            //Nombre de la persona
            $table->string('nombre', 100);
            //Apellidos de la persona
            $table->string('apellidos', 100);
            //Tipo de personal
            $table->enum('tipo_personal', ['interno', 'externo']);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
