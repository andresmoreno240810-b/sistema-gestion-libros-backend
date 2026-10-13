<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">

            <div>
                <h2 class="font-bold text-2xl text-white">
                    Editar autor
                </h2>

                <p class="text-sm text-gray-400 mt-1">
                    Modifica la información del autor.
                </p>
            </div>

            <a href="{{ route('autores.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-5 py-2.5 rounded-lg transition">
                ← Volver
            </a>

        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 rounded-xl shadow-lg p-6">

                <form action="{{ route('autores.update', $autor) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">
                                Nombre
                            </label>

                            <input type="text" name="nombre" value="{{ old('nombre', $autor->nombre) }}" required
                                class="w-full bg-gray-700 border-gray-600 text-white rounded-lg focus:ring-blue-500 focus:border-blue-500">

                            @error('nombre')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">
                                Apellido
                            </label>

                            <input type="text" name="apellido" value="{{ old('apellido', $autor->apellido) }}" required
                                class="w-full bg-gray-700 border-gray-600 text-white rounded-lg focus:ring-blue-500 focus:border-blue-500">

                            @error('apellido')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">
                                Nacionalidad
                            </label>

                            <input type="text" name="nacionalidad"
                                value="{{ old('nacionalidad', $autor->nacionalidad) }}"
                                class="w-full bg-gray-700 border-gray-600 text-white rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="mt-8 flex gap-3">

                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                                Guardar cambios
                            </button>

                            <a href="{{ route('autores.index') }}"
                                class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                                Cancelar
                            </a>

                        </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>