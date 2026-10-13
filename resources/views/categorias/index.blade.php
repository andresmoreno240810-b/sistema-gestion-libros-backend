<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Categorías
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Administra las categorías de los libros.
                </p>
            </div>

            <a href="{{ route('categorias.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700
                      text-white font-semibold rounded-lg shadow-sm transition">
                + Nueva categoría
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 rounded-lg bg-green-100 border border-green-200
                                text-green-800 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                        Lista de categorías
                    </h3>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Total: {{ $categorias->count() }} categorías
                    </p>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-sm text-left text-gray-800 dark:text-gray-100">

                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-4 font-semibold text-gray-600 dark:text-gray-200">
                                    #
                                </th>

                                <th class="px-6 py-4 font-semibold text-gray-600 dark:text-gray-200">
                                    Nombre
                                </th>

                                <th class="px-6 py-4 font-semibold text-gray-600 dark:text-gray-200">
                                    Descripción
                                </th>

                                <th class="px-6 py-4 font-semibold text-gray-600 dark:text-gray-200">
                                    Estado
                                </th>

                                <th class="px-6 py-4 font-semibold text-gray-600 dark:text-gray-200 text-right">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-800 dark:text-gray-100">

                            @forelse($categorias as $categoria)

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">

                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                        {{ $categoria->id }}
                                    </td>

                                    <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">
                                        {{ $categoria->nombre }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $categoria->descripcion ?? 'Sin descripción' }}
                                    </td>

                                    <td class="px-6 py-4">

                                        @if($categoria->estado)

                                            <span class="inline-flex px-3 py-1 rounded-full
                                                                 text-xs font-semibold
                                                                 bg-green-100 text-green-700">
                                                Activa
                                            </span>

                                        @else

                                            <span class="inline-flex px-3 py-1 rounded-full
                                                                 text-xs font-semibold
                                                                 bg-red-100 text-red-700">
                                                Inactiva
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="flex justify-end gap-2">

                                            <a href="{{ route('categorias.edit', $categoria) }}" class="px-3 py-2 rounded-lg bg-blue-100
                                                          hover:bg-blue-200 text-blue-700
                                                          text-sm font-medium transition">
                                                Editar
                                            </a>

                                            <form action="{{ route('categorias.destroy', $categoria) }}" method="POST"
                                                onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="px-3 py-2 rounded-lg bg-red-100
                                                                   hover:bg-red-200 text-red-700
                                                                   text-sm font-medium transition">
                                                    Eliminar
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">

                                        <div class="text-4xl mb-3">
                                            📚
                                        </div>

                                        <p class="font-semibold">
                                            No hay categorías registradas.
                                        </p>

                                        <p class="text-sm mt-1">
                                            Crea la primera categoría para comenzar.
                                        </p>

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