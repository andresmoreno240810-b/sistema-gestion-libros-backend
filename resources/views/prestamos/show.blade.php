<x-app-layout>

    <div class="min-h-screen bg-[#0f172a]">

        <!-- ENCABEZADO -->
        <div class="bg-[#1e293b] border-b border-gray-700">
            <div class="max-w-6xl mx-auto px-6 py-7 flex items-center justify-between">

                <div>
                    <h1 class="text-3xl font-bold text-white">
                        Detalle del préstamo
                    </h1>

                    <p class="text-gray-400 mt-1">
                        Consulta la información completa del préstamo.
                    </p>
                </div>

                <a href="{{ route('prestamos.index') }}"
                   class="bg-gray-600 hover:bg-gray-500 text-white font-semibold px-5 py-3 rounded-lg transition">
                    ← Volver
                </a>

            </div>
        </div>


        <!-- CONTENIDO -->
        <div class="max-w-4xl mx-auto px-6 py-8">

            <div class="bg-[#1e293b] rounded-2xl shadow-xl overflow-hidden">

                <!-- TÍTULO -->
                <div class="px-7 py-6 border-b border-gray-700">

                    <h2 class="text-xl font-bold text-white">
                        Información del préstamo #{{ $prestamo->id }}
                    </h2>

                    <p class="text-gray-400 mt-1">
                        Detalles del usuario, libro y fechas.
                    </p>

                </div>


                <!-- INFORMACIÓN -->
                <div class="p-7">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- USUARIO -->
                        <div class="bg-[#273449] rounded-xl p-5">

                            <p class="text-sm text-gray-400 mb-2">
                                Usuario
                            </p>

                            <p class="text-lg font-semibold text-white">
                                {{ $prestamo->usuario->name ?? 'Sin usuario' }}
                            </p>

                            @if($prestamo->usuario)
                                <p class="text-sm text-gray-400 mt-1">
                                    {{ $prestamo->usuario->email }}
                                </p>
                            @endif

                        </div>


                        <!-- LIBRO -->
                        <div class="bg-[#273449] rounded-xl p-5">

                            <p class="text-sm text-gray-400 mb-2">
                                Libro
                            </p>

                            <p class="text-lg font-semibold text-white">
                                {{ $prestamo->libro->titulo ?? 'Sin libro' }}
                            </p>

                            @if($prestamo->libro && $prestamo->libro->isbn)
                                <p class="text-sm text-gray-400 mt-1">
                                    ISBN: {{ $prestamo->libro->isbn }}
                                </p>
                            @endif

                        </div>


                        <!-- FECHA PRÉSTAMO -->
                        <div class="bg-[#273449] rounded-xl p-5">

                            <p class="text-sm text-gray-400 mb-2">
                                Fecha del préstamo
                            </p>

                            <p class="text-lg font-semibold text-white">
                                {{ \Carbon\Carbon::parse($prestamo->fecha_prestamo)->format('d/m/Y') }}
                            </p>

                        </div>


                        <!-- FECHA DEVOLUCIÓN -->
                        <div class="bg-[#273449] rounded-xl p-5">

                            <p class="text-sm text-gray-400 mb-2">
                                Fecha límite de devolución
                            </p>

                            <p class="text-lg font-semibold text-white">
                                {{ \Carbon\Carbon::parse($prestamo->fecha_devolucion)->format('d/m/Y') }}
                            </p>

                        </div>


                        <!-- FECHA ENTREGA -->
                        <div class="bg-[#273449] rounded-xl p-5">

                            <p class="text-sm text-gray-400 mb-2">
                                Fecha de entrega
                            </p>

                            <p class="text-lg font-semibold text-white">
                                @if($prestamo->fecha_entrega)
                                    {{ \Carbon\Carbon::parse($prestamo->fecha_entrega)->format('d/m/Y') }}
                                @else
                                    Pendiente
                                @endif
                            </p>

                        </div>


                        <!-- ESTADO -->
                        <div class="bg-[#273449] rounded-xl p-5">

                            <p class="text-sm text-gray-400 mb-2">
                                Estado
                            </p>

                            @if($prestamo->estado === 'Prestado')

                                <span class="inline-flex px-4 py-2 rounded-full bg-red-900/50 text-red-300 font-semibold">
                                    Prestado
                                </span>

                            @elseif($prestamo->estado === 'Devuelto')

                                <span class="inline-flex px-4 py-2 rounded-full bg-green-900/50 text-green-300 font-semibold">
                                    Devuelto
                                </span>

                            @else

                                <span class="inline-flex px-4 py-2 rounded-full bg-yellow-900/50 text-yellow-300 font-semibold">
                                    Retrasado
                                </span>

                            @endif

                        </div>

                    </div>


                    <!-- BOTONES -->
                    <div class="flex justify-end gap-3 mt-8">

                        <a href="{{ route('prestamos.index') }}"
                           class="bg-gray-600 hover:bg-gray-500 text-white font-semibold px-5 py-3 rounded-lg transition">
                            Volver
                        </a>

                        <a href="{{ route('prestamos.edit', $prestamo) }}"
                           class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-5 py-3 rounded-lg transition">
                            ✏️ Editar préstamo
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>