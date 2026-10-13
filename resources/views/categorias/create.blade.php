<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                Nueva categoría
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Registra una nueva categoría para los libros.
            </p>
        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">

                <form action="{{ route('categorias.store') }}" method="POST">

                    @csrf

                    <div class="space-y-6">

                        <div>
                            <label for="nombre"
                                   class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                Nombre
                            </label>

                            <input type="text"
                                   name="nombre"
                                   id="nombre"
                                   value="{{ old('nombre') }}"
                                   required
                                   maxlength="100"
                                   placeholder="Ej: Literatura"
                                   class="w-full rounded-lg border-gray-300
                                          dark:border-gray-600 dark:bg-gray-700
                                          dark:text-white focus:border-blue-500
                                          focus:ring-blue-500">

                            @error('nombre')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        <div>
                            <label for="descripcion"
                                   class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                Descripción
                            </label>

                            <textarea name="descripcion"
                                      id="descripcion"
                                      rows="4"
                                      maxlength="255"
                                      placeholder="Describe brevemente la categoría..."
                                      class="w-full rounded-lg border-gray-300
                                             dark:border-gray-600 dark:bg-gray-700
                                             dark:text-white focus:border-blue-500
                                             focus:ring-blue-500">{{ old('descripcion') }}</textarea>

                            @error('descripcion')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        <div>
                            <label for="estado"
                                   class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                Estado
                            </label>

                            <select name="estado"
                                    id="estado"
                                    class="w-full rounded-lg border-gray-300
                                           dark:border-gray-600 dark:bg-gray-700
                                           dark:text-white focus:border-blue-500
                                           focus:ring-blue-500">

                                <option value="1"
                                    {{ old('estado', '1') == '1' ? 'selected' : '' }}>
                                    Activa
                                </option>

                                <option value="0"
                                    {{ old('estado') === '0' ? 'selected' : '' }}>
                                    Inactiva
                                </option>

                            </select>

                            @error('estado')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        <div class="flex items-center justify-end gap-3 pt-4">

                            <a href="{{ route('categorias.index') }}"
                               class="px-5 py-2.5 rounded-lg bg-gray-100
                                      hover:bg-gray-200 text-gray-700
                                      font-semibold transition">
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="px-5 py-2.5 rounded-lg bg-blue-600
                                           hover:bg-blue-700 text-white
                                           font-semibold shadow-sm transition">
                                Guardar categoría
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>