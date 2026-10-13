<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Crear la nueva columna categoria_id
        Schema::table('libros', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id')
                ->nullable()
                ->after('categoria');
        });

        // 2. Pasar las categorías actuales de texto a categoria_id
        $libros = DB::table('libros')
            ->select('id', 'categoria')
            ->get();

        foreach ($libros as $libro) {

            $categoriaId = DB::table('categorias')
                ->where('nombre', $libro->categoria)
                ->value('id');

            if ($categoriaId !== null) {
                DB::table('libros')
                    ->where('id', $libro->id)
                    ->update([
                        'categoria_id' => $categoriaId,
                    ]);
            }
        }

        // 3. Crear la relación con la tabla categorias
        Schema::table('libros', function (Blueprint $table) {
            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias');
        });

        // 4. Eliminar la antigua columna de texto
        Schema::table('libros', function (Blueprint $table) {
            $table->dropColumn('categoria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Recuperar la columna categoria como texto
        Schema::table('libros', function (Blueprint $table) {
            $table->string('categoria', 100)
                ->nullable()
                ->after('categoria_id');
        });

        // 2. Recuperar el nombre de la categoría
        $libros = DB::table('libros')
            ->join('categorias', 'libros.categoria_id', '=', 'categorias.id')
            ->select(
                'libros.id',
                'categorias.nombre as categoria_nombre'
            )
            ->get();

        foreach ($libros as $libro) {
            DB::table('libros')
                ->where('id', $libro->id)
                ->update([
                    'categoria' => $libro->categoria_nombre,
                ]);
        }

        // 3. Eliminar la clave foránea
        Schema::table('libros', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
        });

        // 4. Eliminar categoria_id
        Schema::table('libros', function (Blueprint $table) {
            $table->dropColumn('categoria_id');
        });
    }
};