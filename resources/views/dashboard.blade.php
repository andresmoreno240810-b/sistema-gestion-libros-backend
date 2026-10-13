<x-app-layout>

    <div class="min-h-screen bg-slate-950 py-8">

        <div class="max-w-7xl mx-auto px-6">

            {{-- PANEL DE BIENVENIDA --}}
            <div class="bg-gradient-to-r from-indigo-600 to-blue-700
                        rounded-2xl shadow-xl p-8 mb-8">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between">

                    <div>

                        @if (Auth::user()?->role?->nombre === 'Administrador')

                            <p class="text-indigo-100 text-sm font-bold uppercase tracking-wider">
                                Panel de administrador
                            </p>

                            <h1 class="text-3xl md:text-4xl font-black text-white mt-2">
                                Bienvenido al Sistema de Gestión de Libros
                            </h1>

                            <p class="text-blue-100 mt-3 text-base">
                                Administra libros, categorías, autores, editoriales y préstamos
                                desde un solo lugar.
                            </p>

                        @else

                            <p class="text-indigo-100 text-sm font-bold uppercase tracking-wider">
                                Panel de lector
                            </p>

                            <h1 class="text-3xl md:text-4xl font-black text-white mt-2">
                                Bienvenido al Sistema de Gestión de Libros
                            </h1>

                            <p class="text-blue-100 mt-3 text-base">
                                Consulta la información disponible de la biblioteca desde este panel.
                            </p>

                        @endif

                    </div>


                </div>

                @if (Auth::user()?->role?->nombre === 'Administrador')


                    {{-- ESTADÍSTICAS --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">


                        {{-- LIBROS --}}
                        <div class="bg-slate-800 rounded-2xl shadow-lg p-6
                                                                        border-l-4 border-blue-500
                                                                        hover:shadow-xl hover:-translate-y-1
                                                                        transition duration-300">

                            <div class="flex items-center justify-between">

                                <div>

                                    <p class="text-slate-300 text-sm font-semibold">
                                        Libros
                                    </p>

                                    <p class="text-white text-4xl font-black mt-2">
                                        {{ $totalLibros ?? 0 }}
                                    </p>

                                    <p class="text-slate-400 text-sm mt-1">
                                        Registrados
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- CATEGORÍAS --}}
                        <div class="bg-slate-800 rounded-2xl shadow-lg p-6
                                                                        border-l-4 border-green-500
                                                                        hover:shadow-xl hover:-translate-y-1
                                                                        transition duration-300">

                            <div class="flex items-center justify-between">

                                <div>

                                    <p class="text-slate-300 text-sm font-semibold">
                                        Categorías
                                    </p>

                                    <p class="text-white text-4xl font-black mt-2">
                                        {{ $totalCategorias ?? 0 }}
                                    </p>

                                    <p class="text-slate-400 text-sm mt-1">
                                        Registradas
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- PRÉSTAMOS --}}
                        <div class="bg-slate-800 rounded-2xl shadow-lg p-6
                                                                        border-l-4 border-yellow-500
                                                                        hover:shadow-xl hover:-translate-y-1
                                                                        transition duration-300">

                            <div class="flex items-center justify-between">

                                <div>

                                    <p class="text-slate-300 text-sm font-semibold">
                                        Préstamos
                                    </p>

                                    <p class="text-white text-4xl font-black mt-2">
                                        {{ $totalPrestamos ?? 0 }}
                                    </p>

                                    <p class="text-slate-400 text-sm mt-1">
                                        Registrados
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- USUARIOS --}}
                        <div class="bg-slate-800 rounded-2xl shadow-lg p-6
                                                                        border-l-4 border-red-500
                                                                        hover:shadow-xl hover:-translate-y-1
                                                                        transition duration-300">

                            <div class="flex items-center justify-between">

                                <div>

                                    <p class="text-slate-300 text-sm font-semibold">
                                        Usuarios
                                    </p>

                                    <p class="text-white text-4xl font-black mt-2">
                                        {{ $totalUsuarios ?? 0 }}
                                    </p>

                                    <p class="text-slate-400 text-sm mt-1">
                                        Registrados
                                    </p>

                                </div>
                            </div>

                        </div>

                    </div>


                    {{-- ACCESOS RÁPIDOS --}}
                    <div class="bg-slate-800 rounded-2xl shadow-lg p-6 mt-8">

                        <h2 class="text-xl font-bold text-white">
                            Accesos rápidos
                        </h2>

                        <p class="text-slate-400 mt-1">
                            Administra rápidamente los módulos principales del sistema.
                        </p>


                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3
                                                                        gap-4 mt-6">


                            {{-- LIBROS --}}
                            <a href="{{ route('libros.index') }}" class="group flex items-center gap-4
                                                                          p-5 rounded-xl bg-slate-700
                                                                          hover:bg-slate-600
                                                                          transition duration-200">

                                <div>

                                    <h3 class="font-bold text-white">
                                        Gestionar libros
                                    </h3>

                                    <p class="text-sm text-slate-400 mt-1">
                                        Registrar y administrar libros
                                    </p>

                                </div>

                            </a>


                            {{-- CATEGORÍAS --}}
                            <a href="{{ route('categorias.index') }}" class="group flex items-center gap-4
                                                                          p-5 rounded-xl bg-slate-700
                                                                          hover:bg-slate-600
                                                                          transition duration-200">
                                <div>

                                    <h3 class="font-bold text-white">
                                        Gestionar categorías
                                    </h3>

                                    <p class="text-sm text-slate-400 mt-1">
                                        Administrar categorías
                                    </p>

                                </div>

                            </a>


                            {{-- PRÉSTAMOS --}}
                            <a href="{{ route('prestamos.index') }}" class="group flex items-center gap-4
                                                                          p-5 rounded-xl bg-slate-700
                                                                          hover:bg-slate-600
                                                                          transition duration-200">
                                <div>

                                    <h3 class="font-bold text-white">
                                        Gestionar préstamos
                                    </h3>

                                    <p class="text-sm text-slate-400 mt-1">
                                        Registrar y controlar préstamos
                                    </p>

                                </div>

                            </a>


                            {{-- AUTORES --}}
                            <a href="{{ route('autores.index') }}" class="group flex items-center gap-4
                                                                          p-5 rounded-xl bg-slate-700
                                                                          hover:bg-slate-600
                                                                          transition duration-200">

                                <div>

                                    <h3 class="font-bold text-white">
                                        Gestionar autores
                                    </h3>

                                    <p class="text-sm text-slate-400 mt-1">
                                        Administrar autores
                                    </p>

                                </div>

                            </a>


                            {{-- EDITORIALES --}}
                            <a href="{{ route('editorials.index') }}" class="group flex items-center gap-4
                                                                          p-5 rounded-xl bg-slate-700
                                                                          hover:bg-slate-600
                                                                          transition duration-200">

                                <div>

                                    <h3 class="font-bold text-white">
                                        Gestionar editoriales
                                    </h3>

                                    <p class="text-sm text-slate-400 mt-1">
                                        Administrar editoriales
                                    </p>

                                </div>

                            </a>

                        </div>

                    </div>

                @endif
            </div>

        </div>

</x-app-layout>