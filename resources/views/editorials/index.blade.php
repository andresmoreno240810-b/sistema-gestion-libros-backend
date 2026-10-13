<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">

            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white">
                    Editoriales
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Administra las editoriales de los libros.
                </p>
            </div>

            <a href="{{ route('editorials.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg transition">
                + Nueva editorial
            </a>

        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700">

                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                        Lista de editoriales
                    </h3>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Editoriales registradas actualmente.
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
                                    Acciones
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                            @forelse($editoriales as $editorial)

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">

                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $editorial->id }}
                                    </td>

                                    <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">
                                        {{ $editorial->nombre }}
                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            <a href="{{ route('editorials.edit', $editorial) }}"
                                                class="text-yellow-600 hover:text-yellow-800 font-semibold">
                                                Editar
                                            </a>

                                            <form action="{{ route('editorials.destroy', $editorial) }}" method="POST"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar esta editorial?');">

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

                                    <td colspan="3" class="px-6 py-12 text-center">

                                        <div class="text-5xl mb-4">
                                            📚
                                        </div>

                                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                            No hay editoriales registradas
                                        </h3>

                                        <p class="text-gray-500 dark:text-gray-400 mt-2">
                                            Comienza registrando la primera editorial.
                                        </p>

                                        <a href="{{ route('editorials.create') }}"
                                            class="inline-block mt-5 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg transition">
                                            + Registrar editorial
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