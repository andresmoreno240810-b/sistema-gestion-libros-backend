<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{
    public function index()
    {
        return response()->json(
            Categoria::query()->orderBy('id', 'desc')->get()
        );
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:categorias,nombre'],
            'descripcion' => ['nullable', 'string'],
            'estado' => ['sometimes', 'boolean'],
        ]);

        $categoria = Categoria::create($datos);

        return response()->json([
            'message' => 'Categoría creada correctamente.',
            'data' => $categoria,
        ], 201);
    }

    public function show(Categoria $categoria)
    {
        return response()->json($categoria);
    }

    public function update(Request $request, Categoria $categoria)
    {
        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categorias', 'nombre')->ignore($categoria->id),
            ],
            'descripcion' => ['nullable', 'string'],
            'estado' => ['sometimes', 'boolean'],
        ]);

        $categoria->update($datos);

        return response()->json([
            'message' => 'Categoría actualizada correctamente.',
            'data' => $categoria->fresh(),
        ]);
    }

    public function destroy(Categoria $categoria)
    {
        if ($categoria->libros()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar esta categoría porque tiene libros asociados.',
            ], 409);
        }

        $categoria->delete();

        return response()->json([
            'message' => 'Categoría eliminada correctamente.',
        ]);
    }
}
