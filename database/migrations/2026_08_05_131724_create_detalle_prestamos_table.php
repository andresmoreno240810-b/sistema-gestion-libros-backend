<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_prestamos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('prestamo_id')
                  ->constrained('prestamos')
                  ->onDelete('cascade');

            $table->foreignId('libro_id')
                  ->constrained('libros')
                  ->onDelete('cascade');

            $table->integer('cantidad')->default(1);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_prestamos');
    }
};
