<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('membership_id')->nullable()->constrained('memberships')->onDelete('set null');
            $table->string('concept'); // Concepto de pago (Mensualidad, Clase, etc)
            $table->decimal('amount', 10, 2); // Monto
            $table->string('payment_method')->default('cash'); // Método (cash, card, transfer, etc)
            $table->string('status')->default('completed'); // Estado (pending, completed, failed)
            $table->date('payment_date'); // Fecha del pago
            $table->text('notes')->nullable(); // Notas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
