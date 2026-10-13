<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('libros', function (Blueprint $table) {

            $table->id();

            $table->string('titulo',200);

            $table->string('isbn',20)->unique();

            $table->year('anio_publicacion');

            $table->integer('cantidad');

            $table->integer('disponibles');

            $table->text('descripcion')->nullable();

            $table->boolean('estado')->default(true);

            // Relaciones
            $table->foreignId('categoria_id')->constrained('categorias');

            $table->foreignId('autor_id')->constrained('autors');

            $table->foreignId('editorial_id')->constrained('editorials');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
