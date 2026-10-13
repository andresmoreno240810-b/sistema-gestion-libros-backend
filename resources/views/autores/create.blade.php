<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Registrar autor
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 rounded-xl shadow-lg p-8">

                <h1 class="text-2xl font-bold text-white mb-6">
                    Registrar nuevo autor
                </h1>

                <form method="POST" action="{{ route('autores.store') }}">
                    @csrf

                    <div class="mb-5">
                        <label for="nombre" class="block text-white font-medium mb-2">
                            Nombre
                        </label>

                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                            class="w-full rounded-lg bg-gray-700 border-gray-600 placeholder-gray-400"
                            placeholder="Ingrese el nombre">

                        @error('nombre')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="apellido" class="block text-white font-medium mb-2">
                            Apellido
                        </label>

                        <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}" required
                            class="w-full  rounded-lg bg-gray-700 border-gray-600 placeholder-gray-400"
                            placeholder="Ingrese el apellido">

                        @error('apellido')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="nacionalidad" class="block text-white font-medium mb-2">
                            Nacionalidad
                        </label>

                        <input type="text" name="nacionalidad" id="nacionalidad" value="{{ old('nacionalidad') }}"
                            class="w-full rounded-lg bg-gray-700 border-gray-600 placeholder-gray-400|"
                            placeholder="Ejemplo: Colombiana">

                        @error('nacionalidad')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3">

                        <a href="{{ route('autores.index') }}"
                            class="px-5 py-2.5 bg-gray-600 hover:bg-gray-500 text-white rounded-lg">
                            Cancelar
                        </a>

                        <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
                            Guardar autor
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>