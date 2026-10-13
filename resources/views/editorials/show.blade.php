<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-white">
                Ver Editorial
            </h2>

            <p class="text-sm text-gray-300 mt-1">
                Información de la editorial seleccionada.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 rounded-xl shadow-lg p-8">

                <div class="mb-6">
                    <p class="text-sm text-gray-400">
                        Nombre de la editorial
                    </p>

                    <p class="text-xl font-bold text-white mt-1">
                        {{ $editorial->nombre }}
                    </p>
                </div>

                <div class="flex justify-end gap-3">

                    <a href="{{ route('editorials.index') }}"
                       class="px-5 py-2.5 rounded-lg bg-gray-600 hover:bg-gray-500 text-white font-semibold transition">
                        Volver
                    </a>

                    <a href="{{ route('editorials.edit', $editorial) }}"
                       class="px-5 py-2.5 rounded-lg bg-yellow-600 hover:bg-yellow-700 text-white font-semibold transition">
                        Editar
                    </a>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>