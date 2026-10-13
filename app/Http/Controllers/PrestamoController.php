<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Libro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrestamoController extends Controller
{
    /**
     * Mostrar todos los préstamos.
     */
    public function index()
    {
        $prestamos = Prestamo::with(['usuario', 'libro'])
            ->latest()
            ->get();

        return view('prestamos.index', compact('prestamos'));
    }

    /**
     * Mostrar formulario para crear un préstamo.
     */
    public function create()
    {
        $libros = Libro::where('estado', true)
            ->where('disponibles', '>', 0)
            ->orderBy('titulo')
            ->get();

        $usuarios = User::orderBy('name')->get();

        return view('prestamos.create', compact('libros', 'usuarios'));
    }

    /**
     * Guardar un nuevo préstamo.
     */
    public function store(Request $request)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'libro_id' => 'required|exists:libros,id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'required|date|after_or_equal:fecha_prestamo',
        ]);

        DB::transaction(function () use ($request) {

            $libro = Libro::lockForUpdate()
                ->findOrFail($request->libro_id);

            if ($libro->disponibles <= 0) {
                abort(422, 'El libro seleccionado no tiene ejemplares disponibles.');
            }

            Prestamo::create([
                'user_id' => $request->user_id,
                'libro_id' => $request->libro_id,
                'fecha_prestamo' => $request->fecha_prestamo,
                'fecha_devolucion' => $request->fecha_devolucion,
                'fecha_entrega' => null,
                'estado' => 'Prestado',
            ]);

            $libro->decrement('disponibles');
        });

        return redirect()
            ->route('prestamos.index')
            ->with('success', 'Préstamo registrado correctamente.');
    }

    /**
     * Mostrar un préstamo específico.
     */
    public function show(Prestamo $prestamo)
    {
        $prestamo->load(['usuario', 'libro']);

        return view('prestamos.show', compact('prestamo'));
    }

    /**
     * Mostrar formulario para editar un préstamo.
     */
    public function edit(Prestamo $prestamo)
    {
        $prestamo->load(['usuario', 'libro']);

        return view('prestamos.edit', compact('prestamo'));
    }

    /**
     * Actualizar un préstamo.
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        $request->validate([
            'fecha_devolucion' => 'required|date|after_or_equal:fecha_prestamo',
            'estado' => 'required|in:Prestado,Devuelto,Vencido',
        ]);

        $prestamo->update([
            'fecha_devolucion' => $request->fecha_devolucion,
            'estado' => $request->estado,
        ]);

        return redirect()
            ->route('prestamos.index')
            ->with('success', 'Préstamo actualizado correctamente.');
    }

    /**
     * Registrar devolución de un libro.
     */
    public function devolver(Prestamo $prestamo)
    {
        if ($prestamo->estado === 'Devuelto') {
            return back()->withErrors([
                'prestamo' => 'Este préstamo ya fue devuelto.'
            ]);
        }

        DB::transaction(function () use ($prestamo) {

            $libro = Libro::lockForUpdate()
                ->findOrFail($prestamo->libro_id);

            $libro->increment('disponibles');

            $prestamo->update([
                'fecha_entrega' => now(),
                'estado' => 'Devuelto',
            ]);
        });

        return redirect()
            ->route('prestamos.index')
            ->with('success', 'Libro devuelto correctamente.');
    }

    /**
     * Eliminar un préstamo.
     */
    public function destroy(Prestamo $prestamo)
    {
        $prestamo->delete();

        return redirect()
            ->route('prestamos.index')
            ->with('success', 'Préstamo eliminado correctamente.');
    }
}