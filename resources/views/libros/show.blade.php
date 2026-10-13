@extends('layouts.app')

@section('content')

    <div class="max-w-7xl mx-auto py-10 px-6">

        <div class="flex items-center justify-between mb-8">

            <div>
                <h1 class="text-2xl font-bold text-white">
                    {{ $libro->titulo }}
                </h1>

                <p class="text-gray-400 mt-1">
                    Información completa del libro registrado.
                </p>
            </div>

            <div class="flex gap-3">

                <a href="{{ route('libros.edit', $libro) }}"
                    class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                    Editar
                </a>

                <a href="{{ route('libros.index') }}" class="px-5 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">
                    Volver
                </a>

            </div>

        </div>


        <div class="bg-gray-800 rounded-lg shadow">

            <div class="px-6 py-4 border-b border-gray-700">
                <h2 class="text-lg font-semibold text-white">
                    Información del registro
                </h2>
            </div>


            <div class="p-6 space-y-6">

                <div>
                    <p class="text-sm text-gray-400">Título</p>
                    <p class="text-white mt-1">
                        {{ $libro->titulo }}
                    </p>
                </div>


                <div>
                    <p class="text-sm text-gray-400">ISBN</p>
                    <p class="text-white mt-1">
                        {{ $libro->isbn }}
                    </p>
                </div>


                <div>
                    <p class="text-sm text-gray-400">Año de publicación</p>
                    <p class="text-white mt-1">
                        {{ $libro->anio_publicacion }}
                    </p>
                </div>


                <div>
                    <p class="text-sm text-gray-400">Categoría</p>
                    <p class="text-white mt-1">
                        {{ $libro->categoria->nombre ?? 'Sin categoría' }}
                    </p>
                </div>


                <div>
                    <p class="text-sm text-gray-400">Autor</p>
                    <p class="text-white mt-1">
                        {{ $libro->autor }}
                    </p>
                </div>


                <div>
                    <p class="text-sm text-gray-400">Editorial</p>
                    <p class="text-white mt-1">
                        {{ $libro->editorial }}
                    </p>
                </div>


                <div>
                    <p class="text-sm text-gray-400">Cantidad de ejemplares</p>
                    <p class="text-white mt-1">
                        {{ $libro->cantidad }}
                    </p>
                </div>


                <div>
                    <p class="text-sm text-gray-400">Ejemplares disponibles</p>
                    <p class="text-white mt-1">
                        {{ $libro->disponibles }}
                    </p>
                </div>


                <div>
                    <p class="text-sm text-gray-400">Estado</p>

                    @if($libro->estado)
                        <span class="inline-block mt-1 px-3 py-1 rounded-full bg-green-600 text-white text-sm">
                            Activo
                        </span>
                    @else
                        <span class="inline-block mt-1 px-3 py-1 rounded-full bg-red-600 text-white text-sm">
                            Inactivo
                        </span>
                    @endif

                </div>


                <div>
                    <p class="text-sm text-gray-400">Descripción</p>

                    <div class="mt-2 bg-gray-700 rounded-lg p-4 text-white">
                        {{ $libro->descripcion ?: 'Sin descripción.' }}
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection