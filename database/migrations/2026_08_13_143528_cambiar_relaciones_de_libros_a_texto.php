<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('libros', function (Blueprint $table) {

            // Eliminar las relaciones actuales
            $table->dropForeign(['categoria_id']);
            $table->dropForeign(['autor_id']);
            $table->dropForeign(['editorial_id']);

            $table->dropColumn([
                'categoria_id',
                'autor_id',
                'editorial_id'
            ]);

            // Crear campos de texto
            $table->string('categoria', 100);
            $table->string('autor', 150);
            $table->string('editorial', 150);
        });
    }

    public function down(): void
    {
        Schema::table('libros', function (Blueprint $table) {

            $table->dropColumn([
                'categoria',
                'autor',
                'editorial'
            ]);

            $table->foreignId('categoria_id')
                ->constrained('categorias');

            $table->foreignId('autor_id')
                ->constrained('autors');

            $table->foreignId('editorial_id')
                ->constrained('editorials');
        });
    }
};