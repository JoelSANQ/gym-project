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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre de la clase (yoga, crossfit, etc)
            $table->text('description')->nullable(); // Descripción
            $table->integer('capacity')->default(20); // Capacidad máxima
            $table->string('schedule'); // Horario (ej: "Lunes 10:00 - 11:00")
            $table->foreignId('trainer_id')->nullable()->constrained('users')->onDelete('set null'); // Entrenador
            $table->boolean('is_active')->default(true); // Estado activo/inactivo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
