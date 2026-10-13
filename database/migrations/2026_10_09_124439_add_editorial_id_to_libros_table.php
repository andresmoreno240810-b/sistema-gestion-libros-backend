<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Obtener los libros actuales.
        $libros = DB::table('libros')
            ->select('id', 'editorial')
            ->get();

        // Comprobar que cada editorial de los libros
        // exista en la tabla editorials antes de modificar datos.
        foreach ($libros as $libro) {
            $nombreEditorial = trim((string) $libro->editorial);

            $existe = $nombreEditorial !== ''
                && DB::table('editorials')
                    ->whereRaw(
                        'LOWER(TRIM(nombre)) = ?',
                        [strtolower($nombreEditorial)]
                    )
                    ->exists();

            if (!$existe) {
                throw new RuntimeException(
                    "No se encontró la editorial '{$nombreEditorial}' "
                    . "del libro ID {$libro->id} en la tabla editorials. "
                    . "Verifica las editoriales antes de ejecutar la migración."
                );
            }
        }

        // Crear la nueva columna.
        Schema::table('libros', function (Blueprint $table) {
            $table->unsignedBigInteger('editorial_id')
                ->nullable()
                ->after('editorial');
        });

        // Asociar cada libro con su editorial existente.
        foreach ($libros as $libro) {
            $nombreEditorial = trim((string) $libro->editorial);

            $editorialId = DB::table('editorials')
                ->whereRaw(
                    'LOWER(TRIM(nombre)) = ?',
                    [strtolower($nombreEditorial)]
                )
                ->value('id');

            DB::table('libros')
                ->where('id', $libro->id)
                ->update([
                    'editorial_id' => $editorialId,
                ]);
        }

        // Crear la clave foránea.
        Schema::table('libros', function (Blueprint $table) {
            $table->foreign('editorial_id')
                ->references('id')
                ->on('editorials');
        });

        // Eliminar la antigua columna de texto.
        Schema::table('libros', function (Blueprint $table) {
            $table->dropColumn('editorial');
        });
    }

    public function down(): void
    {
        // Restaurar la columna de texto.
        Schema::table('libros', function (Blueprint $table) {
            $table->string('editorial', 150)
                ->nullable()
                ->after('editorial_id');
        });

        // Recuperar los nombres antes de eliminar la relación.
        $libros = DB::table('libros')
            ->leftJoin(
                'editorials',
                'libros.editorial_id',
                '=',
                'editorials.id'
            )
            ->select(
                'libros.id',
                'editorials.nombre as nombre_editorial'
            )
            ->get();

        foreach ($libros as $libro) {
            DB::table('libros')
                ->where('id', $libro->id)
                ->update([
                    'editorial' => $libro->nombre_editorial,
                ]);
        }

        Schema::table('libros', function (Blueprint $table) {
            $table->dropForeign(['editorial_id']);
            $table->dropColumn('editorial_id');
        });
    }
};