<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Editorial;
use App\Models\Libro;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LibroController extends Controller
{
    public function opciones(): JsonResponse
    {
        return response()->json([
            'categorias' => Categoria::query()->select('id', 'nombre')->orderBy('nombre')->get(),
            'editoriales' => Editorial::query()->select('id', 'nombre')->orderBy('nombre')->get(),
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $query = Libro::query()->with(['categoria:id,nombre', 'editorial:id,nombre'])->orderByDesc('id');

        if ($request->filled('buscar')) {
            $buscar = trim((string) $request->input('buscar'));
            $query->where(function ($subquery) use ($buscar) {
                $subquery->where('titulo', 'like', "%{$buscar}%")
                    ->orWhere('autor', 'like', "%{$buscar}%")
                    ->orWhere('isbn', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->integer('categoria_id'));
        }

        if ($request->input('disponibilidad') === 'disponible') {
            $query->where('disponibles', '>', 0);
        } elseif ($request->input('disponibilidad') === 'no_disponible') {
            $query->where('disponibles', '<=', 0);
        }

        return response()->json($query->get());
    }

    public function show(Libro $libro): JsonResponse
    {
        return response()->json($libro->load(['categoria:id,nombre', 'editorial:id,nombre']));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'titulo' => ['required', 'string', 'max:200'],
            'isbn' => ['required', 'string', 'max:20', Rule::unique('libros', 'isbn')],
            'anio_publicacion' => ['required', 'integer'],
            'cantidad' => ['required', 'integer', 'min:1'],
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
            'autor' => ['required', 'string', 'max:150'],
            'editorial_id' => ['required', 'integer', 'exists:editorials,id'],
            'descripcion' => ['nullable', 'string'],
        ]);

        $data['disponibles'] = (int) $data['cantidad'];
        $data['estado'] = true;
        $libro = Libro::create($data);

        return response()->json([
            'message' => 'Libro registrado correctamente.',
            'libro' => $libro->load(['categoria:id,nombre', 'editorial:id,nombre']),
        ], 201);
    }

    public function update(Request $request, Libro $libro): JsonResponse
    {
        $data = $request->validate([
            'titulo' => ['required', 'string', 'max:200'],
            'isbn' => ['required', 'string', 'max:20', Rule::unique('libros', 'isbn')->ignore($libro->id)],
            'anio_publicacion' => ['required', 'integer'],
            'cantidad' => ['required', 'integer', 'min:1'],
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
            'autor' => ['required', 'string', 'max:150'],
            'editorial_id' => ['required', 'integer', 'exists:editorials,id'],
            'descripcion' => ['nullable', 'string'],
        ]);

        $prestados = max(0, (int) $libro->cantidad - (int) $libro->disponibles);
        $cantidadNueva = (int) $data['cantidad'];
        $disponiblesNuevos = $cantidadNueva - $prestados;

        if ($disponiblesNuevos < 0) {
            return response()->json([
                'message' => 'La cantidad no puede ser menor que los ejemplares actualmente prestados.',
                'errors' => ['cantidad' => ['La cantidad no puede ser menor que los ejemplares actualmente prestados.']],
            ], 422);
        }

        $data['disponibles'] = $disponiblesNuevos;
        $libro->update($data);

        return response()->json([
            'message' => 'Libro actualizado correctamente.',
            'libro' => $libro->fresh()->load(['categoria:id,nombre', 'editorial:id,nombre']),
        ]);
    }

    public function destroy(Libro $libro): JsonResponse
    {
        $tieneDetalle = DB::table('detalle_prestamos')->where('libro_id', $libro->id)->exists();
        $tienePrestamoDirecto = DB::table('prestamos')->where('libro_id', $libro->id)->exists();

        if ($tieneDetalle || $tienePrestamoDirecto) {
            return response()->json([
                'message' => 'No se puede eliminar este libro porque está asociado a registros de préstamos.',
            ], 422);
        }

        $libro->delete();

        return response()->json(['message' => 'Libro eliminado correctamente.']);
    }
}