@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-10 px-6">

    <div class="flex items-center justify-between mb-8">

        <div>
            <h1 class="text-2xl font-bold text-white">
                Editar libro
            </h1>

            <p class="text-gray-400 mt-1">
                Modifica la información del libro registrado.
            </p>
        </div>

        <a href="{{ route('libros.show', $libro) }}"
           class="px-5 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">
            Volver
        </a>

    </div>


    <div class="bg-gray-800 rounded-lg shadow">

        <div class="px-6 py-4 border-b border-gray-700">
            <h2 class="text-lg font-semibold text-white">
                Información del libro
            </h2>
        </div>


        <form action="{{ route('libros.update', $libro) }}"
              method="POST"
              class="p-6">

            @csrf
            @method('PUT')


            {{-- Mostrar errores --}}
            @if ($errors->any())

                <div class="mb-6 bg-red-600 text-white rounded-lg p-4">

                    <p class="font-semibold mb-2">
                        Hay algunos errores:
                    </p>

                    <ul class="list-disc list-inside">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <div class="space-y-6">


                {{-- Título --}}
                <div>

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Título del libro *
                    </label>

                    <input
                        type="text"
                        name="titulo"
                        value="{{ old('titulo', $libro->titulo) }}"
                        required
                        maxlength="200"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                </div>


                {{-- ISBN --}}
                <div>

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        ISBN *
                    </label>

                    <input
                        type="text"
                        name="isbn"
                        value="{{ old('isbn', $libro->isbn) }}"
                        required
                        maxlength="20"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                </div>


                {{-- Año --}}
                <div>

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Año de publicación *
                    </label>

                    <input
                        type="number"
                        name="anio_publicacion"
                        value="{{ old('anio_publicacion', $libro->anio_publicacion) }}"
                        required
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                </div>


                {{-- Categoría --}}
                <div>

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Categoría *
                    </label>

                    <select
                    id="categoria_id"
                    name = "categoria_id"
                    required
                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                    <option value="">
                        Selecciona una categoría
                    </option>

                    @foreach($categorias as $categoria)

                        <option value="{{ $categoria->id }}"
                            {{ old('categoria_id', $libro->categoria_id) == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
                
                @error('categoria_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>


                {{-- Autor --}}
                <div>

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Autor *
                    </label>

                    <input
                        type="text"
                        name="autor"
                        value="{{ old('autor', $libro->autor) }}"
                        required
                        maxlength="150"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                </div>


                {{-- Editorial --}}
                <div>

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Editorial *
                    </label>

                    <select
                        id="editorial_id"
                        name="editorial_id"
                        required
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    
                        <option value="">
                            Selecciona una editorial
                        </option>

                        @foreach($editoriales as $editorial)
                        <option
                        value="{{ $editorial->id }}"
                        {{ old('editorial_id', $libro->editorial_id) == $editorial->id ? 'selected' : '' }}>
                            {{ $editorial->nombre }}
                        </option>
                        @endforeach
                    </select>

                    @error('editorial_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Cantidad --}}
                <div>

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Cantidad de ejemplares *
                    </label>

                    <input
                        type="number"
                        id="cantidad"
                        name="cantidad"
                        value="{{ old('cantidad', $libro->cantidad) }}"
                        min="1"
                        required
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                    <p class="text-sm text-gray-400 mt-2">
                        Cantidad total de ejemplares físicos del libro.
                    </p>

                </div>


                {{-- Disponibles --}}
                <div>

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Ejemplares disponibles
                    </label>

                    <input
                        type="number"
                        id="disponibles"
                        value="{{ old('disponibles', $libro->disponibles) }}"
                        readonly
                        class="w-full px-4 py-2 bg-gray-600 border border-gray-600 rounded-lg text-gray-200 cursor-not-allowed"
                    >

                    <p class="text-sm text-gray-400 mt-2">
                        Se calcula automáticamente según los ejemplares prestados.
                    </p>

                </div>


                {{-- Estado --}}
                <div>

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Estado
                    </label>

                    <select
                        name="estado"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                        <option value="1"
                            {{ old('estado', $libro->estado) == 1 ? 'selected' : '' }}>
                            Activo
                        </option>

                        <option value="0"
                            {{ old('estado', $libro->estado) == 0 ? 'selected' : '' }}>
                            Inactivo
                        </option>

                    </select>

                </div>


                {{-- Descripción --}}
                <div>

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Descripción
                    </label>

                    <textarea
                        name="descripcion"
                        rows="5"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >{{ old('descripcion', $libro->descripcion) }}</textarea>

                </div>


            </div>


            {{-- Botones --}}
            <div class="flex justify-end gap-3 mt-8">

                <a href="{{ route('libros.show', $libro) }}"
                   class="px-5 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                    Guardar cambios
                </button>

            </div>


        </form>

    </div>

</div>


{{-- Actualizar disponibles visualmente --}}
<script>

    const cantidadInput = document.getElementById('cantidad');
    const disponiblesInput = document.getElementById('disponibles');

    const cantidadInicial = {{ $libro->cantidad }};
    const disponiblesIniciales = {{ $libro->disponibles }};

    const prestados = cantidadInicial - disponiblesIniciales;


    cantidadInput.addEventListener('input', function () {

        let cantidad = parseInt(this.value) || 0;

        let disponibles = cantidad - prestados;

        if (disponibles < 0) {
            disponibles = 0;
        }

        disponiblesInput.value = disponibles;

    });

</script>

@endsection