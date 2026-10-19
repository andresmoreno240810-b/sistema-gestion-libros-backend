<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Editorial;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EditorialController extends Controller
{
    public function index()
    {
        return response()->json(
            Editorial::query()->orderBy('id', 'desc')->get()
        );
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:editorials,nombre'],
        ]);

        $editorial = Editorial::create($datos);

        return response()->json([
            'message' => 'Editorial creada correctamente.',
            'data' => $editorial,
        ], 201);
    }

    public function show(Editorial $editorial)
    {
        return response()->json($editorial);
    }

    public function update(Request $request, Editorial $editorial)
    {
        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('editorials', 'nombre')->ignore($editorial->id),
            ],
        ]);

        $editorial->update($datos);

        return response()->json([
            'message' => 'Editorial actualizada correctamente.',
            'data' => $editorial->fresh(),
        ]);
    }

    public function destroy(Editorial $editorial)
    {
        if ($editorial->libros()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar esta editorial porque tiene libros asociados.',
            ], 409);
        }

        $editorial->delete();

        return response()->json([
            'message' => 'Editorial eliminada correctamente.',
        ]);
    }
}
