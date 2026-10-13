<x-app-layout>

    <div class="min-h-screen bg-[#0f172a]">

        <!-- ENCABEZADO -->
        <div class="bg-[#1e293b] border-b border-gray-700">
            <div class="max-w-6xl mx-auto px-6 py-7 flex items-center justify-between">

                <div>
                    <h1 class="text-3xl font-bold text-white">
                        Editar préstamo
                    </h1>

                    <p class="text-gray-400 mt-1">
                        Actualiza la información del préstamo.
                    </p>
                </div>

                <a href="{{ route('prestamos.index') }}"
                   class="bg-gray-600 hover:bg-gray-500 text-white font-semibold px-5 py-3 rounded-lg transition">
                    ← Volver
                </a>

            </div>
        </div>


        <!-- FORMULARIO -->
        <div class="max-w-3xl mx-auto px-6 py-8">

            <div class="bg-[#1e293b] rounded-2xl shadow-xl overflow-hidden">

                <div class="px-7 py-6 border-b border-gray-700">

                    <h2 class="text-xl font-bold text-white">
                        Información del préstamo #{{ $prestamo->id }}
                    </h2>

                    <p class="text-gray-400 mt-1">
                        Modifica las fechas o el estado del préstamo.
                    </p>

                </div>


                <form method="POST"
                      action="{{ route('prestamos.update', $prestamo) }}"
                      class="p-7">

                    @csrf
                    @method('PUT')


                    <!-- INFORMACIÓN DEL USUARIO -->
                    <div class="mb-6">

                        <label class="block text-sm font-semibold text-gray-300 mb-2">
                            Usuario
                        </label>

                        <div class="bg-[#273449] border border-gray-600 rounded-lg px-4 py-3 text-white">
                            {{ $prestamo->usuario->name ?? 'Sin usuario' }}

                            @if($prestamo->usuario)
                                <span class="text-gray-400 text-sm ml-2">
                                    — {{ $prestamo->usuario->email }}
                                </span>
                            @endif
                        </div>

                    </div>


                    <!-- INFORMACIÓN DEL LIBRO -->
                    <div class="mb-6">

                        <label class="block text-sm font-semibold text-gray-300 mb-2">
                            Libro
                        </label>

                        <div class="bg-[#273449] border border-gray-600 rounded-lg px-4 py-3 text-white">
                            {{ $prestamo->libro->titulo ?? 'Sin libro' }}

                            @if($prestamo->libro && $prestamo->libro->isbn)
                                <span class="text-gray-400 text-sm ml-2">
                                    — ISBN: {{ $prestamo->libro->isbn }}
                                </span>
                            @endif
                        </div>

                    </div>


                    <!-- FECHA DEL PRÉSTAMO -->
                    <div class="mb-6">

                        <label class="block text-sm font-semibold text-white mb-2">
                            Fecha del préstamo
                        </label>

                        <input type="date"
                               name="fecha_prestamo"
                               value="{{ old('fecha_prestamo', \Carbon\Carbon::parse($prestamo->fecha_prestamo)->format('Y-m-d')) }}"
                               readonly
                               style="color: white !important; background-color: #374151 !important; color-scheme: dark;"
                               class="w-full border border-gray-600 rounded-lg px-4 py-3">

                    </div>


                    <!-- FECHA DE DEVOLUCIÓN -->
                    <div class="mb-6">

                        <label class="block text-sm font-semibold text-white mb-2">
                            Fecha límite de devolución
                        </label>

                        <input type="date"
                               name="fecha_devolucion"
                               value="{{ old('fecha_devolucion', \Carbon\Carbon::parse($prestamo->fecha_devolucion)->format('Y-m-d')) }}"
                               required
                               style="color: white !important; background-color: #374151 !important; color-scheme: dark;"
                               class="w-full border border-gray-600 rounded-lg px-4 py-3">

                    </div>


                    <!-- ESTADO -->
                    <div class="mb-8">

                        <label class="block text-sm font-semibold text-white mb-2">
                            Estado
                        </label>

                        <select name="estado"
                                required
                                style="color: white !important; background-color: #374151 !important; color-scheme: dark;"
                                class="w-full border border-gray-600 rounded-lg px-4 py-3">

                            <option value="Prestado"
                                {{ old('estado', $prestamo->estado) === 'Prestado' ? 'selected' : '' }}>
                                Prestado
                            </option>

                            <option value="Devuelto"
                                {{ old('estado', $prestamo->estado) === 'Devuelto' ? 'selected' : '' }}>
                                Devuelto
                            </option>

                            <option value="Retrasado"
                                {{ old('estado', $prestamo->estado) === 'Retrasado' ? 'selected' : '' }}>
                                Retrasado
                            </option>

                        </select>

                    </div>


                    <!-- BOTONES -->
                    <div class="flex justify-end gap-3">

                        <a href="{{ route('prestamos.index') }}"
                           class="bg-gray-600 hover:bg-gray-500 text-white font-semibold px-5 py-3 rounded-lg transition">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-5 py-3 rounded-lg transition">
                            💾 Guardar cambios
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
</x-app-layout>