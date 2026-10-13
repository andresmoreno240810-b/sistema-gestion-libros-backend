<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-white">
                Registrar Editorial
            </h2>

            <p class="text-sm text-gray-300 mt-1">
                Registra una nueva editorial para asociarla a los libros.
            </p>
        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 rounded-xl shadow-lg p-8">

                <form action="{{ route('editorials.store') }}" method="POST">

                    @csrf

                    <div class="mb-6">

                        <label for="nombre"
                               class="block text-sm font-semibold text-white mb-2">
                            Nombre de la editorial
                        </label>

                        <input
                            type="text"
                            id="nombre"
                            name="nombre"
                            value="{{ old('nombre') }}"
                            placeholder="Ej: Editorial Planeta"
                            class="w-full rounded-lg bg-gray-700 border-gray-600 placeholder-gray-400"
                            required
                        >

                        @error('nombre')
                            <p class="text-red-400 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <div class="flex justify-end gap-3">

                        <a href="{{ route('editorials.index') }}"
                           class="px-5 py-2.5 rounded-lg bg-gray-600 hover:bg-gray-500 text-white font-semibold transition">
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                            Registrar Editorial
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>