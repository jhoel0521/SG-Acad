<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel del Docente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Mis Materias</h3>
                    @if($materias->isEmpty())
                        <p>No tienes materias asignadas.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($materias as $materia)
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-bold">{{ $materia->nombre }}</h4>
                                    <p class="text-sm text-gray-600">{{ $materia->codigo }}</p>
                                    <div class="mt-2 space-y-2">
                                        <a href="{{ route('docente.estudiantes', $materia) }}" class="block bg-blue-500 hover:bg-blue-700 text-white text-center py-1 px-2 rounded text-sm">Ver Estudiantes</a>
                                        <a href="{{ route('docente.asistencia', $materia) }}" class="block bg-green-500 hover:bg-green-700 text-white text-center py-1 px-2 rounded text-sm">Tomar Asistencia</a>
                                        <a href="{{ route('docente.calificaciones', $materia) }}" class="block bg-yellow-500 hover:bg-yellow-700 text-white text-center py-1 px-2 rounded text-sm">Gestionar Calificaciones</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>