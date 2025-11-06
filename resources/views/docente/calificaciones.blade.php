<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestionar Calificaciones - ') . $materia->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('docente.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Volver al Dashboard</a>

                    <form method="POST" action="{{ route('docente.guardar_calificaciones', $materia) }}">
                        @csrf

                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">Estudiante</th>
                                    <th class="py-2 px-4 border-b">Calificación</th>
                                    <th class="py-2 px-4 border-b">Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inscripciones as $inscripcion)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $inscripcion->estudiante->usuario->name }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <input type="number" step="0.01" min="0" max="100" name="calificaciones[{{ $inscripcion->id }}][valor]" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-20" value="{{ $inscripcion->calificaciones->first()?->valor_calificacion }}">
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            <input type="text" name="calificaciones[{{ $inscripcion->id }}][descripcion]" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Ej: Primer Parcial" value="{{ $inscripcion->calificaciones->first()?->descripcion }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Guardar Calificaciones
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>