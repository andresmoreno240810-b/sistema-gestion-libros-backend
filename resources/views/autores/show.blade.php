<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">

            <div>
                <h2 class="font-bold text-2xl text-white">
                    Información del autor
                </h2>

                <p class="text-sm text-gray-400 mt-1">
                    Consulta la información completa del autor.
                </p>
            </div>

            <a href="{{ route('autores.index') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-5 py-2.5 rounded-lg transition">
                ← Volver
            </a>

        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">

                <div class="p-6 border-b border-gray-700">

                    <h3 class="text-xl font-bold text-white">
                        {{ $autor->nombre }} {{ $autor->apellido }}
                    </h3>

                    <p class="text-gray-400 mt-1">
                        Información registrada en el sistema.
                    </p>

                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <p class="text-sm text-gray-400">
                            Nombre
                        </p>

                        <p class="text-white font-semibold mt-1">
                            {{ $autor->nombre }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">
                            Apellido
                        </p>

                        <p class="text-white font-semibold mt-1">
                            {{ $autor->apellido }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">
                            Nacionalidad
                        </p>

                        <p class="text-white font-semibold mt-1">
                            {{ $autor->nacionalidad ?? 'No registrada' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">
                            Fecha de nacimiento
                        </p>

                        <p class="text-white font-semibold mt-1">
                            {{ $autor->fecha_nacimiento ? $autor->fecha_nacimiento->format('d/m/Y') : 'No registrada' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">
                            Estado
                        </p>

                        @if($autor->estado)

                            <span class="inline-block mt-1 px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-700">
                                Activo
                            </span>

                        @else

                            <span class="inline-block mt-1 px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-700">
                                Inactivo
                            </span>

                        @endif
                    </div>

                </div>

                <div class="p-6 border-t border-gray-700 flex gap-3">

                    <a href="{{ route('autores.edit', $autor) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-5 py-2.5 rounded-lg transition">
                        Editar autor
                    </a>

                    <a href="{{ route('autores.index') }}"
                       class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-5 py-2.5 rounded-lg transition">
                        Volver a autores
                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>