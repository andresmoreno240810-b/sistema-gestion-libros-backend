<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    public function index()
    {
        return response()->json(
            Autor::query()->orderBy('id', 'desc')->get()
        );
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['nullable', 'string', 'max:255'],
            'nacionalidad' => ['nullable', 'string', 'max:255'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'estado' => ['sometimes', 'boolean'],
        ]);

        $autor = Autor::create($datos);

        return response()->json([
            'message' => 'Autor creado correctamente.',
            'data' => $autor,
        ], 201);
    }

    public function show(Autor $autor)
    {
        return response()->json($autor);
    }

    public function update(Request $request, Autor $autor)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['nullable', 'string', 'max:255'],
            'nacionalidad' => ['nullable', 'string', 'max:255'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'estado' => ['sometimes', 'boolean'],
        ]);

        $autor->update($datos);

        return response()->json([
            'message' => 'Autor actualizado correctamente.',
            'data' => $autor->fresh(),
        ]);
    }

    public function destroy(Autor $autor)
    {
        $autor->delete();

        return response()->json([
            'message' => 'Autor eliminado correctamente.',
        ]);
    }
}
