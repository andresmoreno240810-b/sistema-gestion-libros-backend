<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PrestamoController extends Controller
{
    public function opciones(): JsonResponse
    {
        $lectores = User::query()
            ->where('role_id', 2)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        $libros = Libro::query()
            ->where('estado', true)
            ->where('disponibles', '>', 0)
            ->orderBy('titulo')
            ->get(['id', 'titulo', 'isbn', 'disponibles']);

        return response()->json([
            'lectores' => $lectores,
            'libros' => $libros,
        ]);
    }

    /**
     * Consultar todos los préstamos con sus usuarios y libros.
     */
    public function index(): JsonResponse
    {
        $prestamos = Prestamo::with([
            'usuario:id,name,email',
            'detalles.libro:id,titulo,isbn',
        ])
            ->latest()
            ->get();

        return response()->json($prestamos);
    }

    /**
     * Registrar un préstamo con uno o varios libros.
     */
    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'required|date|after_or_equal:fecha_prestamo',

            'libros' => 'required|array|min:1',
            'libros.*.libro_id' => [
                'required',
                'integer',
                'distinct',
                'exists:libros,id',
            ],
            'libros.*.cantidad' => 'required|integer|min:1',
        ]);

        $prestamo = DB::transaction(function () use ($datos) {
            $idsLibros = collect($datos['libros'])
                ->pluck('libro_id')
                ->map(fn ($id) => (int) $id)
                ->all();

            // Bloquear los libros mientras verificamos sus existencias.
            $libros = Libro::whereIn('id', $idsLibros)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($datos['libros'] as $item) {
                $libro = $libros->get((int) $item['libro_id']);

                if (! $libro || ! $libro->estado) {
                    throw ValidationException::withMessages([
                        'libros' => 'Uno de los libros seleccionados está inactivo.',
                    ]);
                }

                if ((int) $libro->disponibles < (int) $item['cantidad']) {
                    throw ValidationException::withMessages([
                        'libros' => "No hay suficientes ejemplares disponibles de: {$libro->titulo}.",
                    ]);
                }
            }

            /*
             * prestamos.libro_id se conserva temporalmente porque
             * la tabla actual todavía requiere ese campo.
             * El primer libro también se registra en detalle_prestamos.
             */
            $prestamo = Prestamo::create([
                'user_id' => $datos['user_id'],
                'libro_id' => (int) $datos['libros'][0]['libro_id'],
                'fecha_prestamo' => $datos['fecha_prestamo'],
                'fecha_devolucion' => $datos['fecha_devolucion'],
                'fecha_entrega' => null,
                'estado' => 'Prestado',
            ]);

            foreach ($datos['libros'] as $item) {
                $libro = $libros->get((int) $item['libro_id']);
                $cantidad = (int) $item['cantidad'];

                $prestamo->detalles()->create([
                    'libro_id' => $libro->id,
                    'cantidad' => $cantidad,
                ]);

                $libro->decrement('disponibles', $cantidad);
            }

            return $prestamo;
        });

        $prestamo->load([
            'usuario:id,name,email',
            'detalles.libro:id,titulo,isbn',
        ]);

        return response()->json([
            'message' => 'Préstamo registrado correctamente.',
            'prestamo' => $prestamo,
        ], 201);
    }
}
