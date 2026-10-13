<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Nuevo préstamo
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Registra un nuevo préstamo de un libro.
                </p>
            </div>

            <a href="{{ route('prestamos.index') }}"
               class="px-4 py-2 rounded-lg
                      bg-gray-600 hover:bg-gray-500
                      text-white font-semibold transition">

                ← Volver

            </a>

        </div>

    </x-slot>


    <div class="py-8">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden">

                {{-- ENCABEZADO DEL FORMULARIO --}}
                <div class="px-6 py-5 border-b border-gray-700">

                    <h3 class="text-xl font-bold text-white">
                        Información del préstamo
                    </h3>

                    <p class="text-sm text-gray-400 mt-1">
                        Completa los datos para registrar el préstamo.
                    </p>

                </div>


                {{-- ERRORES --}}
                @if($errors->any())

                    <div class="mx-6 mt-6 rounded-lg
                                bg-red-900/30
                                border border-red-800
                                text-red-300
                                px-4 py-3">

                        <p class="font-semibold mb-2">
                            Revisa los siguientes errores:
                        </p>

                        <ul class="list-disc list-inside">

                            @foreach($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                <form action="{{ route('prestamos.store') }}"
                      method="POST"
                      class="p-6">

                    @csrf


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                        {{-- USUARIO --}}
                        <div class="relative">

                            <label for="usuario_busqueda"
                                   class="block text-sm font-semibold
                                          text-gray-200 mb-2">

                                Usuario

                            </label>

                            <input type="text"
                            id="usuario_busqueda"
                            autocomplete="off"
                            placeholder="Escribe el nombre o correo..."
                            class="w-full rounded-lg bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500">

                            <input type="hidden"
                                      name="user_id"
                                      id="user_id">

                            <div id="usuarios_resultados"
                                class="absolute z-50 left-0 right-0 mt-1 bg-gray-700 border border-gray-600 rounded-lg shadow-x1 overflow-hidden hidden">

                                @foreach($usuarios as $usuario)
                                
                                <button type="button"
                                class="usuario-opcion block w-full text-left px-4 py-3 text-white hover:bg-gray-600 transition"
                                data-id="{{ $usuario-> id}}"
                                data-search="{{ strtolower($usuario->name . '' . $usuario->email) }}"
                                data-text="{{ $usuario->name}} - {{ $usuario->email }}">

                                <div class="font-semibold">
                                    {{ $usuario->name}}
                                </div>

                                <div class="text-sm text-gray-400">
                                    {{ $usuario->email}}
                                </div>

                            </button>   
                                @endforeach

                        </div>

                        <p id="usuario_seleccionado"
                        class="text-xs text-green-400 mt-2 hidden">
                        ✓ Usuario seleccionado
                        </p>


                        {{-- LIBRO --}}
                        <div>

                            <label for="libro_busqueda"
                                   class="block text-sm font-semibold
                                          text-gray-200 mb-2">

                                Libro

                            </label>

                            <input type="text"
                            id="libro_busqueda"
                            autocomplete="off"
                            placeholder="Escribe el título o ISBN..."
                            class="w-full rounded-lg bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500">

                            <input type="hidden" name="libro_id" id="libro_id">

                            <div id="libros_resultados" class="absolute z-50 left-0 right-0 mt-1 bg-gray-700 border border-gray-600 rounded-lg shadow-xl overflow-hidden hidden">

                                @foreach($libros as $libro)

                        <button type="button"
                        class="libro-opcion block w-full text-left px-4 py-3 text-white hover:bg-gray-600 transition"
                        data-id="{{ $libro->id}}"
                        data-search="{{ strtolower($libro->titulo. '' . ($libro->isbn ?? '')) }}"
                        data-text="{{ $libro->titulo }}">

                        <div class="font-semibold">
                            {{ $libro->titulo}}
                        </div>

                        @if($libro->isbn)
                        <div class="text-sm text-gray-400">
                            ISBN: {{ $libro->isbn}}
                        </div>
                        @endif

                        <div class="text-xs text-green-400 mt-1">
                            {{ $libro->disponibles }} disponibles
                        </div>
                    </button>

                @endforeach

                <p id="libro_seleccionado"
                class="text-xs text-green-400 mt-2 hidden">
                ✓ Libro seleccionado
                </p>

                            

            </div>


                        {{-- FECHA PRÉSTAMO --}}
                        <div>

                            <label for="fecha_prestamo"
                                   class="block text-sm font-semibold
                                          text-gray-200 mb-2">

                                Fecha del préstamo

                            </label>

                            <input type="date"
                                   name="fecha_prestamo"
                                   id="fecha_prestamo"
                                   value="{{ old('fecha_prestamo', now()->format('Y-m-d')) }}"
                                   required
                                   class="w-full rounded-lg
                                          bg-gray-700
                                          border-gray-600
                                          text-white
                                          focus:border-blue-500
                                          focus:ring-blue-500">

                        </div>


                        {{-- FECHA DEVOLUCIÓN --}}
                        <div>

                            <label for="fecha_devolucion"
                                   class="block text-sm font-semibold
                                          text-gray-200 mb-2">

                                Fecha límite de devolución

                            </label>

                            <input type="date"
                                   name="fecha_devolucion"
                                   id="fecha_devolucion"
                                   value="{{ old('fecha_devolucion') }}"
                                   required
                                   class="w-full rounded-lg
                                          bg-gray-700
                                          border-gray-600
                                          text-white
                                          focus:border-blue-500
                                          focus:ring-blue-500">

                        </div>

                    </div>

                    {{-- BOTONES --}}
                    <div class="flex items-center justify-end gap-3 mt-8">

                        <a href="{{ route('prestamos.index') }}"
                           class="px-5 py-2.5 rounded-lg
                                  bg-gray-600 hover:bg-gray-500
                                  text-white font-semibold transition">

                            Cancelar

                        </a>


                        <button type="submit"
                                class="px-5 py-2.5 rounded-lg
                                       bg-blue-600 hover:bg-blue-700
                                       text-white font-semibold
                                       shadow-lg transition">

                            📖 Registrar préstamo

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // USUARIO
    // ==========================================

    const usuarioInput = document.getElementById('usuario_busqueda');
    const usuarioId = document.getElementById('user_id');
    const usuariosResultados = document.getElementById('usuarios_resultados');
    const usuarioSeleccionado = document.getElementById('usuario_seleccionado');

    const usuariosOpciones =
        document.querySelectorAll('.usuario-opcion');


    usuarioInput.addEventListener('input', function () {

        const texto = this.value.toLowerCase().trim();

        usuarioId.value = '';
        usuarioSeleccionado.classList.add('hidden');

        if (texto === '') {
            usuariosResultados.classList.add('hidden');
            return;
        }

        let encontrados = [];

        usuariosOpciones.forEach(function (opcion) {

            const contenido =
                opcion.dataset.search.toLowerCase();

            if (contenido.includes(texto)) {

                opcion.classList.remove('hidden');

                encontrados.push(opcion);

            } else {

                opcion.classList.add('hidden');

            }

        });


        // Si hay coincidencias mostramos resultados
        if (encontrados.length > 0) {

            usuariosResultados.classList.remove('hidden');

        } else {

            usuariosResultados.classList.add('hidden');

        }


        // ==========================================
        // SELECCIÓN AUTOMÁTICA
        // ==========================================

        // Si existe UNA coincidencia exacta,
        // la seleccionamos automáticamente.

    if (encontrados.length === 1) {

    const usuario = encontrados[0];

    usuarioId.value = usuario.dataset.id;

    usuarioSeleccionado.classList.remove('hidden');

}

    });


    // Selección manual de usuario

    usuariosOpciones.forEach(function (opcion) {

        opcion.addEventListener('click', function () {

            usuarioInput.value =
                this.dataset.text;

            usuarioId.value =
                this.dataset.id;

            usuariosResultados.classList.add('hidden');

            usuarioSeleccionado.classList.remove('hidden');

        });

    });


    // ==========================================
    // LIBRO
    // ==========================================

    const libroInput =
        document.getElementById('libro_busqueda');

    const libroId =
        document.getElementById('libro_id');

    const librosResultados =
        document.getElementById('libros_resultados');

    const libroSeleccionado =
        document.getElementById('libro_seleccionado');

    const librosOpciones =
        document.querySelectorAll('.libro-opcion');


    libroInput.addEventListener('input', function () {

        const texto =
            this.value.toLowerCase().trim();

        libroId.value = '';

        libroSeleccionado.classList.add('hidden');


        if (texto === '') {

            librosResultados.classList.add('hidden');

            return;
        }


        let encontrados = [];


        librosOpciones.forEach(function (opcion) {

            const contenido =
                opcion.dataset.search.toLowerCase();


            if (contenido.includes(texto)) {

                opcion.classList.remove('hidden');

                encontrados.push(opcion);

            } else {

                opcion.classList.add('hidden');

            }

        });


        if (encontrados.length > 0) {

            librosResultados.classList.remove('hidden');

        } else {

            librosResultados.classList.add('hidden');

        }


        // ==========================================
        // SELECCIÓN AUTOMÁTICA DEL LIBRO
        // ==========================================

    if (encontrados.length === 1) {

    const libro = encontrados[0];

    libroId.value = libro.dataset.id;

    libroSeleccionado.classList.remove('hidden');

}

    });


    // Selección manual de libro

    librosOpciones.forEach(function (opcion) {

        opcion.addEventListener('click', function () {

            libroInput.value =
                this.dataset.text;

            libroId.value =
                this.dataset.id;

            librosResultados.classList.add('hidden');

            libroSeleccionado.classList.remove('hidden');

        });

    });


    // ==========================================
    // CERRAR RESULTADOS
    // ==========================================

    document.addEventListener('click', function (event) {

        if (
            !usuarioInput.contains(event.target) &&
            !usuariosResultados.contains(event.target)
        ) {

            usuariosResultados.classList.add('hidden');

        }


        if (
            !libroInput.contains(event.target) &&
            !librosResultados.contains(event.target)
        ) {

            librosResultados.classList.add('hidden');

        }

    });


    // ==========================================
    // VALIDACIÓN
    // ==========================================

    const formulario =
        document.querySelector('form');


    formulario.addEventListener('submit', function (event) {

        /*
         * Si el usuario escribió exactamente
         * un usuario existente, ya tendrá su ID.
         */

        if (!usuarioId.value) {

            event.preventDefault();

            alert(
                'Escribe y selecciona un usuario registrado.'
            );

            usuarioInput.focus();

            return;
        }


        /*
         * Si el libro escrito corresponde
         * a un libro existente, tendrá su ID.
         */

        if (!libroId.value) {

            event.preventDefault();

            alert(
                'Escribe y selecciona un libro disponible.'
            );

            libroInput.focus();

            return;
        }

    });

});
</script>
</x-app-layout>