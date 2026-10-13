<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Gestión de Préstamos
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Administra y controla los préstamos de libros.
                </p>
            </div>

            <a href="{{ route('prestamos.create') }}"
               class="inline-flex items-center px-4 py-2
                      bg-blue-600 hover:bg-blue-700
                      text-white font-semibold rounded-lg
                      shadow-sm transition">

                📖 + Nuevo préstamo

            </a>

        </div>
    </x-slot>


    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            {{-- MENSAJE DE ÉXITO --}}
            @if(session('success'))

                <div class="mb-6 rounded-lg
                            bg-green-100 dark:bg-green-900/30
                            border border-green-200 dark:border-green-800
                            text-green-800 dark:text-green-300
                            px-4 py-3">

                    {{ session('success') }}

                </div>

            @endif


            {{-- ERRORES --}}
            @if($errors->any())

                <div class="mb-6 rounded-lg
                            bg-red-100 dark:bg-red-900/30
                            border border-red-200 dark:border-red-800
                            text-red-800 dark:text-red-300
                            px-4 py-3">

                    <ul class="list-disc list-inside">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- RESUMEN --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">


                {{-- TOTAL --}}
                <div class="bg-gray-800 rounded-2xl shadow-lg
                            p-6 border-l-4 border-blue-500">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-semibold text-gray-400">
                                Total de préstamos
                            </p>

                            <p class="text-4xl font-black text-white mt-2">
                                {{ $prestamos->count() }}
                            </p>

                        </div>

                        <div class="bg-blue-900/40
                                    text-blue-400
                                    rounded-xl p-4 text-2xl">

                            📚

                        </div>

                    </div>

                </div>


                {{-- ACTIVOS --}}
                <div class="bg-gray-800 rounded-2xl shadow-lg
                            p-6 border-l-4 border-yellow-500">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-semibold text-gray-400">
                                Préstamos activos
                            </p>

                            <p class="text-4xl font-black text-white mt-2">
                                {{ $prestamos->where('estado', 'Activo')->count() }}
                            </p>

                        </div>

                        <div class="bg-yellow-900/40
                                    text-yellow-400
                                    rounded-xl p-4 text-2xl">

                            📖

                        </div>

                    </div>

                </div>


                {{-- DEVUELTOS --}}
                <div class="bg-gray-800 rounded-2xl shadow-lg
                            p-6 border-l-4 border-green-500">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-semibold text-gray-400">
                                Libros devueltos
                            </p>

                            <p class="text-4xl font-black text-white mt-2">
                                {{ $prestamos->where('estado', 'Devuelto')->count() }}
                            </p>

                        </div>

                        <div class="bg-green-900/40
                                    text-green-400
                                    rounded-xl p-4 text-2xl">

                            ✅

                        </div>

                    </div>

                </div>

            </div>


            {{-- TABLA --}}
            <div class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden">


                {{-- CABECERA --}}
                <div class="px-6 py-5
                            border-b border-gray-700">

                    <h3 class="text-xl font-bold text-white">
                        Lista de préstamos
                    </h3>

                    <p class="text-sm text-gray-400 mt-1">
                        Consulta y administra los préstamos registrados.
                    </p>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full text-sm text-left">


                        {{-- ENCABEZADOS --}}
                        <thead class="bg-gray-700">

                            <tr>

                                <th class="px-6 py-4
                                           font-semibold text-gray-200">
                                    #
                                </th>

                                <th class="px-6 py-4
                                           font-semibold text-gray-200">
                                    Usuario
                                </th>

                                <th class="px-6 py-4
                                           font-semibold text-gray-200">
                                    Libro
                                </th>

                                <th class="px-6 py-4
                                           font-semibold text-gray-200">
                                    Fecha préstamo
                                </th>

                                <th class="px-6 py-4
                                           font-semibold text-gray-200">
                                    Fecha devolución
                                </th>

                                <th class="px-6 py-4
                                           font-semibold text-gray-200">
                                    Entrega
                                </th>

                                <th class="px-6 py-4
                                           font-semibold text-gray-200">
                                    Estado
                                </th>

                                <th class="px-6 py-4
                                           font-semibold text-gray-200 text-right">
                                    Acciones
                                </th>

                            </tr>

                        </thead>


                        {{-- CUERPO --}}
                        <tbody class="divide-y divide-gray-700">


                            @forelse($prestamos as $prestamo)

                                <tr class="hover:bg-gray-700/50 transition">


                                    {{-- ID --}}
                                    <td class="px-6 py-4
                                               text-gray-400">

                                        {{ $prestamo->id }}

                                    </td>


                                    {{-- USUARIO --}}
                                    <td class="px-6 py-4">

                                        <div class="font-semibold text-white">

                                            {{ $prestamo->usuario?->name ?? 'Usuario no disponible' }}

                                        </div>

                                        <div class="text-xs text-gray-400">

                                            {{ $prestamo->usuario?->email ?? '' }}

                                        </div>

                                    </td>


                                    {{-- LIBRO --}}
                                    <td class="px-6 py-4">

                                        <div class="font-semibold text-white">

                                            {{ $prestamo->libro?->titulo ?? 'Libro no disponible' }}

                                        </div>

                                        @if($prestamo->libro?->isbn)

                                            <div class="text-xs text-gray-400">

                                                ISBN: {{ $prestamo->libro->isbn }}

                                            </div>

                                        @endif

                                    </td>


                                    {{-- FECHA PRÉSTAMO --}}
                                    <td class="px-6 py-4 text-gray-300">

                                        {{ $prestamo->fecha_prestamo
                                            ? \Carbon\Carbon::parse($prestamo->fecha_prestamo)->format('d/m/Y')
                                            : '—' }}

                                    </td>


                                    {{-- FECHA DEVOLUCIÓN --}}
                                    <td class="px-6 py-4 text-gray-300">

                                        {{ $prestamo->fecha_devolucion
                                            ? \Carbon\Carbon::parse($prestamo->fecha_devolucion)->format('d/m/Y')
                                            : '—' }}

                                    </td>


                                    {{-- FECHA ENTREGA --}}
                                    <td class="px-6 py-4 text-gray-300">

                                        {{ $prestamo->fecha_entrega
                                            ? \Carbon\Carbon::parse($prestamo->fecha_entrega)->format('d/m/Y')
                                            : 'Pendiente' }}

                                    </td>


                                    {{-- ESTADO --}}
                                    <td class="px-6 py-4">

                                        @if($prestamo->estado === 'Activo')

                                            <span class="inline-flex px-3 py-1
                                                         rounded-full
                                                         text-xs font-semibold
                                                         bg-yellow-900/40
                                                         text-yellow-300">

                                                Activo

                                            </span>

                                        @elseif($prestamo->estado === 'Devuelto')

                                            <span class="inline-flex px-3 py-1
                                                         rounded-full
                                                         text-xs font-semibold
                                                         bg-green-900/40
                                                         text-green-300">

                                                Devuelto

                                            </span>

                                        @else

                                            <span class="inline-flex px-3 py-1
                                                         rounded-full
                                                         text-xs font-semibold
                                                         bg-red-900/40
                                                         text-red-300">

                                                {{ $prestamo->estado }}

                                            </span>

                                        @endif

                                    </td>


                                    {{-- ACCIONES --}}
                                    <td class="px-6 py-4">

                                        <div class="flex justify-end gap-2">


                                            {{-- VER --}}
                                            <a href="{{ route('prestamos.show', $prestamo) }}"
                                               class="px-3 py-2
                                                      rounded-lg
                                                      bg-gray-600
                                                      hover:bg-gray-500
                                                      text-white
                                                      text-sm
                                                      font-medium
                                                      transition">

                                                Ver

                                            </a>


                                            {{-- EDITAR --}}
                                            <a href="{{ route('prestamos.edit', $prestamo) }}"
                                               class="px-3 py-2
                                                      rounded-lg
                                                      bg-blue-600
                                                      hover:bg-blue-700
                                                      text-white
                                                      text-sm
                                                      font-medium
                                                      transition">

                                                Editar

                                            </a>


                                            {{-- DEVOLVER --}}
                                            @if($prestamo->estado !== 'Devuelto')

                                                <form action="{{ route('prestamos.devolver', $prestamo) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('¿Confirmas que este libro fue devuelto?');">

                                                    @csrf
                                                    @method('PATCH')

                                                </form>

                                            @endif


                                            {{-- ELIMINAR --}}
                                            <form action="{{ route('prestamos.destroy', $prestamo) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este préstamo?');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="px-3 py-2
                                                               rounded-lg
                                                               bg-red-600
                                                               hover:bg-red-700
                                                               text-white
                                                               text-sm
                                                               font-medium
                                                               transition">

                                                    Eliminar

                                                </button>

                                            </form>


                                        </div>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td colspan="8"
                                        class="px-6 py-16 text-center">


                                        <div class="text-6xl mb-4">
                                            📚
                                        </div>


                                        <p class="text-xl
                                                  font-bold
                                                  text-white">

                                            No hay préstamos registrados

                                        </p>


                                        <p class="text-gray-400 mt-2">

                                            Crea el primer préstamo para comenzar.

                                        </p>


                                        <a href="{{ route('prestamos.create') }}"
                                           class="inline-flex items-center
                                                  mt-6 px-5 py-3
                                                  bg-blue-600
                                                  hover:bg-blue-700
                                                  text-white
                                                  font-semibold
                                                  rounded-lg
                                                  transition">

                                            + Registrar préstamo

                                        </a>

                                    </td>

                                </tr>

                            @endforelse


                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>