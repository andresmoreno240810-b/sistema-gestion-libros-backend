<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white">
                Registrar nuevo libro
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Agrega un nuevo libro al catálogo de la biblioteca.
            </p>
        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">

                {{-- Encabezado --}}
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">

                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                        Información del libro
                    </h3>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Completa los datos necesarios para registrar el libro.
                    </p>

                </div>

                {{-- Formulario --}}
                <form action="{{ route('libros.store') }}" method="POST">

                    @csrf

                    <div class="p-6 space-y-6">

                        {{-- Título --}}
                        <div>

                            <label for="titulo"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                Título del libro *
                            </label>

                            <input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" required
                                maxlength="200"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">

                            @error('titulo')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- ISBN y año --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>

                                <label for="isbn"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                    ISBN *
                                </label>

                                <input type="text" id="isbn" name="isbn" value="{{ old('isbn') }}" required
                                    maxlength="20"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">

                                @error('isbn')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            <div>

                                <label for="anio_publicacion"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                    Año de publicación *
                                </label>

                                <input type="number" id="anio_publicacion" name="anio_publicacion"
                                    value="{{ old('anio_publicacion') }}" required min="1000" max="{{ date('Y') }}"
                                    placeholder="{{ date('Y') }}"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">

                                @error('anio_publicacion')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>


                        {{-- Categoría, autor y editorial --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            {{-- Categoría --}}
                            <div>

                                <label for="categoria"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                    Categoría *
                                </label>

                                <select id="categoria" name="categoria_id" required
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">

                                    <option value="">Selecciona una categoría</option>

                                    @foreach($categorias as $categoria)

                                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>

                                    @endforeach
                                </select>

                                @error('categoria_id')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Autor --}}
                            <div>

                                <label for="autor"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                    Autor *
                                </label>

                                <input type="text" name="autor" id="autor" value="{{old('autor')}}" required
                                    maxlength="150"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">

                                </select>

                                @error('autor')
                                    <p class="mt-1 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Editorial --}}
                            <div>

                                <label for="editorial_id"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                    Editorial *
                                </label>

                                <select id="editorial_id" name="editorial_id" required
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 drak:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Selecciona una editorial</option>

                                    @foreach($editoriales as $editorial)

                                        <option value="{{ $editorial->id }}" {{ old('editorial_id') == $editorial->id ? 'selected' : '' }}>
                                            {{ $editorial->nombre }}
                                        </option>

                                    @endforeach
                                </select>

                                @error('editorial_id')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                                    {{-- Cantidad --}}
                                    <div class="max-w-sm">

                                        <label for="cantidad"
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                            Cantidad de ejemplares *
                                        </label>

                                        <input type="number" id="cantidad" name="cantidad"
                                            value="{{ old('cantidad', 1) }}" required min="1"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">

                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            Los ejemplares disponibles se establecerán automáticamente.
                                        </p>

                                        @error('cantidad')
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

                                        <textarea id="descripcion" name="descripcion" rows="4"
                                            placeholder="Escribe una breve descripción del libro..."
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">{{ old('descripcion') }}</textarea>

                                        @error('descripcion')
                                            <p class="mt-1 text-sm text-red-600">
                                                {{ $message }}
                                            </p>
                                        @enderror

                                    </div>

                            </div>


                            {{-- Botones --}}
                            <div
                                class="px-6 py-5 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">

                                <a href="{{ route('libros.index') }}"
                                    class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition">
                                    Cancelar
                                </a>

                                <button type="submit"
                                    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition">
                                    Guardar libro
                                </button>

                            </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>