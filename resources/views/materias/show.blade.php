<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Materia: ') . $materia->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p><strong>Nombre:</strong> {{ $materia->nombre }}</p>
                    <p><strong>Código:</strong> {{ $materia->codigo }}</p>
                    <p><strong>Docente:</strong> {{ $materia->docente->usuario->name }}</p>

                    <a href="{{ route('materias.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mt-4 inline-block">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>