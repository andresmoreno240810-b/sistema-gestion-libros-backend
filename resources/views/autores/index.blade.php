<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white">
                    Autores
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Administra los autores registrados en el sistema.
                </p>
            </div>

            <a href="{{ route('autores.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg transition">
                + Nuevo autor
            </a>
        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700">

                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                        Lista de autores
                    </h3>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Autores registrados actualmente.
                    </p>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-left">

                        <thead class="bg-gray-100 dark:bg-gray-700">

                            <tr>

                                <th class="px-6 py-4 text-sm font-bold text-gray-700 dark:text-gray-200">
                                    #
                                </th>

                                <th class="px-6 py-4 text-sm font-bold text-gray-700 dark:text-gray-200">
                                    Nombre
                                </th>

                                <th class="px-6 py-4 text-sm font-bold text-gray-700 dark:text-gray-200">
                                    Apellido
                                </th>

                                <th class="px-6 py-4 text-sm font-bold text-gray-700 dark:text-gray-200">
                                    Nacionalidad
                                </th>

                                <th class="px-6 py-4 text-sm font-bold text-gray-700 dark:text-gray-200">
                                    Acciones
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                            @forelse($autores as $autor)

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">

                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $autor->id }}
                                    </td>

                                    <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">
                                        {{ $autor->nombre }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $autor->apellido }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $autor->nacionalidad ?? 'No registrada' }}
                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-2">

                                            <a href="{{ route('autores.edit', $autor) }}"
                                                class="text-yellow-600 hover:text-yellow-800 font-semibold">
                                                Editar
                                            </a>

                                            <form action="{{ route('autores.destroy', $autor) }}" method="POST"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar este autor?');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                                    Eliminar
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7" class="px-6 py-12 text-center">

                                        <div class="text-5xl mb-4">
                                            ✍️
                                        </div>

                                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                            No hay autores registrados
                                        </h3>

                                        <p class="text-gray-500 dark:text-gray-400 mt-2">
                                            Comienza registrando el primer autor.
                                        </p>

                                        <a href="{{ route('autores.create') }}"
                                            class="inline-block mt-5 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg transition">
                                            + Registrar autor
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