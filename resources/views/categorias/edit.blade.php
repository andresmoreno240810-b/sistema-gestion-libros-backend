<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white">
                    Editar categoría
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Modifica la información de la categoría.
                </p>
            </div>

            <a href="{{ route('categorias.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-5 py-2.5 rounded-lg transition">
                Volver
            </a>
        </div>
    </x-slot>


    <div class="py-8">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">

                {{-- Encabezado --}}
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">

                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                        Información de la categoría
                    </h3>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Actualiza los datos necesarios y guarda los cambios.
                    </p>

                </div>


                {{-- Errores --}}
                @if($errors->any())

                    <div class="mx-6 mt-6 bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg">

                        <ul class="list-disc list-inside">

                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- Formulario --}}
                <form action="{{ route('categorias.update', $categoria) }}" method="POST">

                    @csrf
                    @method('PUT')


                    <div class="p-6 space-y-6">


                        {{-- Nombre --}}
                        <div>

                            <label for="nombre"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                Nombre *
                            </label>

                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $categoria->nombre) }}"
                                required maxlength="100"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">

                            @error('nombre')

                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- Descripción --}}
                        <div>

                            <label for="descripcion"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                Descripción
                            </label>

                            <textarea id="descripcion" name="descripcion" rows="5"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">{{ old('descripcion', $categoria->descripcion) }}</textarea>

                            @error('descripcion')

                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- Estado --}}
                        <div>

                            <label for="estado"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                Estado *
                            </label>

                            <select id="estado" name="estado" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">

                                <option value="1" {{ old('estado', $categoria->estado) == 1 ? 'selected' : '' }}>
                                    Activa
                                </option>

                                <option value="0" {{ old('estado', $categoria->estado) == 0 ? 'selected' : '' }}>
                                    Inactiva
                                </option>

                            </select>

                            @error('estado')

                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                    </div>


                    {{-- Botones --}}
                    <div
                        class="px-6 py-5 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">

                        <a href="{{ route('categorias.index') }}"
                            class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition">
                            Cancelar
                        </a>

                        <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition">
                            Guardar cambios
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>