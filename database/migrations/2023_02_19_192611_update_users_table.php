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
        Schema::table('users', function (Blueprint $table) {
            $table->after('password', function ($table) {
                $table->boolean('es_administrador')->nullable();
                $table->boolean('es_gestor')->nullable();
                $table->boolean('es_tecnico')->nullable();
                $table->boolean('es_consultor')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('es_administrador');
            $table->dropColumn('es_gestor');
            $table->dropColumn('es_tecnico');
            $table->dropColumn('es_consultor');
        });
    }
};
