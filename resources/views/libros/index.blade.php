<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white">
                    Gestión de Libros
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Administra el catálogo de libros de la biblioteca.
                </p>
            </div>

            <a href="{{ route('libros.create') }}"
                class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition">

                + Nuevo libro

            </a>
        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensaje de éxito --}}
            @if (session('success'))

                <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>

            @endif

            {{-- Buscador --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6">

                <form method="GET" action="{{ route('libros.index') }}">

                    <div class="flex flex-col md:flex-row gap-3">

                        <input type="text" name="buscar" value="{{ request('buscar') }}"
                            placeholder="Buscar por título o ISBN..."
                            class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">

                        <button type="submit"
                            class="px-6 py-2.5 bg-gray-800 hover:bg-gray-900 text-white font-semibold rounded-lg transition">
                            Buscar
                        </button>

                        @if(request('buscar'))

                            <a href="{{ route('libros.index') }}"
                                class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg text-center transition">
                                Limpiar
                            </a>

                        @endif

                    </div>

                </form>

            </div>

            {{-- Tabla --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">

                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                        Catálogo de libros
                    </h3>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        {{ $libros->count() }} libro(s) registrado(s)
                    </p>

                </div>

                @if($libros->count() > 0)

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <thead class="bg-gray-50 dark:bg-gray-700">

                                <tr>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">
                                        Libro
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">
                                        ISBN
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">
                                        Categoría
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">
                                        Autor
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">
                                        Editorial
                                    </th>

                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">
                                        Disponibilidad
                                    </th>

                                    <th
                                        class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">
                                        Acciones
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                                @foreach($libros as $libro)

                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">

                                        <td class="px-6 py-4">

                                            <div class="font-semibold text-gray-900 dark:text-white">
                                                {{ $libro->titulo }}
                                            </div>

                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $libro->anio_publicacion }}
                                            </div>

                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                            {{ $libro->isbn }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                            {{ $libro->categoria->nombre ?? 'Sin categoría' }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                            {{ $libro->autor ?? 'Sin autor' }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                            {{ $libro->editorial->nombre ?? 'Sin editorial' }}
                                        </td>

                                        <td class="px-6 py-4 text-center">

                                            @if($libro->disponibles > 0)

                                                <span
                                                    class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                                    {{ $libro->disponibles }} disponibles
                                                </span>

                                            @else

                                                <span
                                                    class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                                    No disponible
                                                </span>

                                            @endif

                                        </td>

                                        <td class="px-6 py-4">

                                            <div class="flex justify-end gap-2">

                                                <a href="{{ route('libros.edit', $libro) }}"
                                                    class="px-3 py-2 text-sm font-semibold text-yellow-600 hover:bg-yellow-50 rounded-lg">
                                                    Editar
                                                </a>

                                                <form action="{{ route('libros.destroy', $libro) }}" method="POST"
                                                    onsubmit="return confirm('¿Estás seguro de eliminar este libro?');">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-lg">
                                                        Eliminar
                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="p-12 text-center">

                        <div class="text-5xl mb-4">
                            📚
                        </div>

                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                            No hay libros registrados
                        </h3>

                        <p class="text-gray-500 dark:text-gray-400 mt-2">
                            Comienza agregando el primer libro al catálogo.
                        </p>

                        <a href="{{ route('libros.create') }}"
                            class="inline-block mt-5 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg">
                            + Registrar primer libro
                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>