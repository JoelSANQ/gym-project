<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('plan_name'); // Plan de membresía (Basic, Premium, VIP)
            $table->decimal('price', 10, 2); // Precio mensual
            $table->text('description')->nullable(); // Descripción del plan
            $table->date('start_date'); // Fecha de inicio
            $table->date('end_date')->nullable(); // Fecha de vencimiento
            $table->boolean('is_active')->default(true); // Estado activo/inactivo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
