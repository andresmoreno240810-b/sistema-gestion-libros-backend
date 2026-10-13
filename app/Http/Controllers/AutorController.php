<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    /**
     * Mostrar todos los autores.
     */
    public function index()
    {
        $autores = Autor::latest()->get();

        return view('autores.index', compact('autores'));
    }

    /**
     * Mostrar formulario para crear un autor.
     */
    public function create()
    {
        return view('autores.create');
    }

    /**
     * Guardar un nuevo autor.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'nacionalidad' => 'nullable|string|max:100',
        ]);

        Autor::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'nacionalidad' => $request->nacionalidad,
        ]);

        return redirect()
            ->route('autores.index')
            ->with('success', 'Autor creado correctamente.');
    }

    /**
     * Mostrar un autor específico.
     */
    public function show(Autor $autor)
    {
        return view('autores.show', compact('autor'));
    }

    /**
     * Mostrar formulario para editar un autor.
     */
    public function edit(Autor $autor)
    {
        return view('autores.edit', compact('autor'));
    }

    /**
     * Actualizar un autor.
     */
    public function update(Request $request, Autor $autor)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'nacionalidad' => 'nullable|string|max:100',
        ]);

        $autor->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'nacionalidad' => $request->nacionalidad,
        ]);

        return redirect()
            ->route('autores.index')
            ->with('success', 'Autor actualizado correctamente.');
    }

    /**
     * Eliminar un autor.
     */
    public function destroy(Autor $autor)
    {
        $autor->delete();

        return redirect()
            ->route('autores.index')
            ->with('success', 'Autor eliminado correctamente.');
    }
}