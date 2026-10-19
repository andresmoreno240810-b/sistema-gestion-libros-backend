<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PrestamoController extends Controller
{
    public function opciones(): JsonResponse
    {
        return response()->json([
            'lectores' => User::where('role_id', 2)
                ->orderBy('name')
                ->get(['id', 'name', 'email']),

            'libros' => Libro::where('estado', true)
                ->where('disponibles', '>', 0)
                ->orderBy('titulo')
                ->get(['id', 'titulo', 'isbn', 'disponibles']),
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $consulta = Prestamo::with([
            'usuario:id,name,email',
            'detalles.libro:id,titulo,isbn',
        ]);

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');

            $consulta->where(function ($q) use ($buscar) {
                $q->where('id', $buscar)
                    ->orWhereHas('usuario', function ($usuario) use ($buscar) {
                        $usuario->where('name', 'like', "%{$buscar}%")
                            ->orWhere('email', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('detalles.libro', function ($libro) use ($buscar) {
                        $libro->where('titulo', 'like', "%{$buscar}%")
                            ->orWhere('isbn', 'like', "%{$buscar}%");
                    });
            });
        }

        if ($request->filled('estado')) {
            $estado = $request->input('estado');

            if (!in_array($estado, ['Prestado', 'Devuelto', 'Retrasado'], true)) {
                throw ValidationException::withMessages([
                    'estado' => 'El estado seleccionado no es válido.',
                ]);
            }

            $consulta->where('estado', $estado);
        }

        if ($request->filled('fecha_desde')) {
            $request->validate([
                'fecha_desde' => ['date'],
            ]);

            $consulta->whereDate(
                'fecha_prestamo',
                '>=',
                $request->input('fecha_desde')
            );
        }

        if ($request->filled('fecha_hasta')) {
            $request->validate([
                'fecha_hasta' => ['date'],
            ]);

            $consulta->whereDate(
                'fecha_prestamo',
                '<=',
                $request->input('fecha_hasta')
            );
        }

        return response()->json(
            $consulta->latest()->get()
        );
    }

    public function show(Prestamo $prestamo): JsonResponse
    {
        $prestamo->load([
            'usuario:id,name,email',
            'detalles.libro:id,titulo,isbn',
        ]);

        return response()->json($prestamo);
    }

    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'fecha_prestamo' => ['required', 'date'],
            'fecha_devolucion' => [
                'required',
                'date',
                'after_or_equal:fecha_prestamo',
            ],
            'libros' => ['required', 'array', 'min:1'],
            'libros.*.libro_id' => [
                'required',
                'integer',
                'distinct',
                'exists:libros,id',
            ],
            'libros.*.cantidad' => ['required', 'integer', 'min:1'],
        ]);

        $prestamo = DB::transaction(function () use ($datos) {
            $idsLibros = collect($datos['libros'])
                ->pluck('libro_id')
                ->map(fn ($id) => (int) $id)
                ->all();

            $libros = Libro::whereIn('id', $idsLibros)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($datos['libros'] as $item) {
                $libro = $libros->get((int) $item['libro_id']);

                if (!$libro || !$libro->estado) {
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

    public function update(Request $request, Prestamo $prestamo): JsonResponse
    {
        $datos = $request->validate([
            'fecha_devolucion' => [
                'required',
                'date',
                'after_or_equal:fecha_prestamo',
            ],
        ]);

        if ($prestamo->estado === 'Devuelto') {
            throw ValidationException::withMessages([
                'prestamo' => 'No se puede modificar un préstamo ya devuelto.',
            ]);
        }

        $prestamo->update([
            'fecha_devolucion' => $datos['fecha_devolucion'],
            'estado' => 'Prestado',
        ]);

        return response()->json([
            'message' => 'Préstamo actualizado correctamente.',
            'prestamo' => $prestamo->fresh(),
        ]);
    }

    public function devolver(Prestamo $prestamo): JsonResponse
    {
        DB::transaction(function () use ($prestamo) {
            $prestamo = Prestamo::whereKey($prestamo->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($prestamo->estado === 'Devuelto') {
                throw ValidationException::withMessages([
                    'prestamo' => 'Este préstamo ya fue devuelto.',
                ]);
            }

            $detalles = $prestamo->detalles()
                ->orderBy('libro_id')
                ->get();

            if ($detalles->isEmpty()) {
                throw ValidationException::withMessages([
                    'prestamo' => 'El préstamo no tiene libros asociados.',
                ]);
            }

            $libros = Libro::whereIn(
                'id',
                $detalles->pluck('libro_id')->unique()
            )
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($detalles as $detalle) {
                $libro = $libros->get($detalle->libro_id);

                if (!$libro) {
                    throw ValidationException::withMessages([
                        'prestamo' => 'No se encontró uno de los libros asociados.',
                    ]);
                }

                $libro->increment('disponibles', $detalle->cantidad);
            }

            $prestamo->update([
                'fecha_entrega' => now()->toDateString(),
                'estado' => 'Devuelto',
            ]);
        });

        return response()->json([
            'message' => 'Devolución registrada correctamente.',
            'prestamo' => $prestamo->fresh(),
        ]);
    }
}
