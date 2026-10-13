<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Categoria;
use App\Models\Editorial;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    public function index()
    {
        $libros = Libro::with(['categoria', 'editorial'])
            ->latest()
            ->get();

        return view('libros.index', compact('libros'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $editoriales = Editorial::orderBy('nombre')->get();

        return view(
            'libros.create',
            compact('categorias', 'editoriales')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'isbn' => 'required|string|max:20|unique:libros,isbn',
            'anio_publicacion' => 'required|integer',
            'cantidad' => 'required|integer|min:1',
            'categoria_id' => 'required|exists:categorias,id',
            'autor' => 'required|string|max:150',
            'editorial_id' => 'required|exists:editorials,id',
            'descripcion' => 'nullable|string',
        ]);

        Libro::create([
            'titulo' => $request->titulo,
            'isbn' => $request->isbn,
            'anio_publicacion' => $request->anio_publicacion,
            'cantidad' => $request->cantidad,
            'disponibles' => $request->cantidad,
            'categoria_id' => $request->categoria_id,
            'autor' => $request->autor,
            'editorial_id' => $request->editorial_id,
            'descripcion' => $request->descripcion,
            'estado' => true,
        ]);

        return redirect()
            ->route('libros.index')
            ->with('success', 'Libro registrado correctamente.');
    }

    public function show(Libro $libro)
    {
        $libro->load(['categoria', 'editorial']);

        return view('libros.show', compact('libro'));
    }

    public function edit(Libro $libro)
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $editoriales = Editorial::orderBy('nombre')->get();

        return view(
            'libros.edit',
            compact('libro', 'categorias', 'editoriales')
        );
    }

    public function update(Request $request, Libro $libro)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'isbn' => 'required|string|max:20|unique:libros,isbn,' . $libro->id,
            'anio_publicacion' => 'required|integer',
            'cantidad' => 'required|integer|min:1',
            'categoria_id' => 'required|exists:categorias,id',
            'autor' => 'required|string|max:150',
            'editorial_id' => 'required|exists:editorials,id',
            'descripcion' => 'nullable|string',
        ]);

        // Calcular cuántos ejemplares están prestados.
        $prestados = $libro->cantidad - $libro->disponibles;

        $nuevaCantidad = $request->cantidad;

        $nuevosDisponibles = $nuevaCantidad - $prestados;

        if ($nuevosDisponibles < 0) {
            return back()
                ->withInput()
                ->withErrors([
                    'cantidad' => 'La cantidad no puede ser menor que los ejemplares actualmente prestados.'
                ]);
        }

        $libro->update([
            'titulo' => $request->titulo,
            'isbn' => $request->isbn,
            'anio_publicacion' => $request->anio_publicacion,
            'cantidad' => $nuevaCantidad,
            'disponibles' => $nuevosDisponibles,
            'categoria_id' => $request->categoria_id,
            'autor' => $request->autor,
            'editorial_id' => $request->editorial_id,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()
            ->route('libros.index')
            ->with('success', 'Libro actualizado correctamente.');
    }

    public function destroy(Libro $libro)
    {
        $libro->delete();

        return redirect()
            ->route('libros.index')
            ->with('success', 'Libro eliminado correctamente.');
    }
}