<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Cursos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($inscripciones->isEmpty())
                        <p>No estás inscrito en ningún curso.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($inscripciones as $inscripcion)
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-bold">{{ $inscripcion->materia->nombre }}</h4>
                                    <p class="text-sm text-gray-600">{{ $inscripcion->materia->codigo }}</p>
                                    <p class="text-sm">Docente: {{ $inscripcion->materia->docente->usuario->name }}</p>
                                    <p class="text-sm">Estado: {{ $inscripcion->estado }}</p>
                                    <div class="mt-2">
                                        <a href="{{ route('estudiante.ver_curso', $inscripcion->materia) }}" class="block bg-blue-500 hover:bg-blue-700 text-white text-center py-1 px-2 rounded text-sm">Ver Curso</a>
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