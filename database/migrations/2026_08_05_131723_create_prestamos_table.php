<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestamos', function (Blueprint $table) {

            $table->id();

            $table->date('fecha_prestamo');

            $table->date('fecha_devolucion');

            $table->date('fecha_entrega')->nullable();

            $table->enum('estado', [
                'Prestado',
                'Devuelto',
                'Retrasado'
            ])->default('Prestado');

            // Usuario que solicita el préstamo
            $table->foreignId('user_id')->constrained('users');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
