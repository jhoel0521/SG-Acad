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

                    <h3 class="text-lg font-medium mb-4">Agregar Nuevas Calificaciones</h3>
                    <form method="POST" action="{{ route('docente.guardar_calificaciones', $materia) }}">
                        @csrf

                        <table class="min-w-full bg-white mb-6">
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
                                            <input type="number" step="0.01" min="0" max="100" name="calificaciones[{{ $inscripcion->id }}][valor]" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-20">
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            <input type="text" name="calificaciones[{{ $inscripcion->id }}][descripcion]" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Ej: Primer Parcial">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mb-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Guardar Calificaciones
                            </button>
                        </div>
                    </form>

                    <h3 class="text-lg font-medium mb-4">Calificaciones Registradas</h3>
                    @foreach($inscripciones as $inscripcion)
                        <div class="mb-4 border rounded p-4">
                            <h4 class="font-bold">{{ $inscripcion->estudiante->usuario->name }}</h4>
                            @if($inscripcion->calificaciones->isEmpty())
                                <p class="text-gray-500">No hay calificaciones registradas.</p>
                            @else
                                <table class="min-w-full bg-white mt-2">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b">Descripción</th>
                                            <th class="py-2 px-4 border-b">Calificación</th>
                                            <th class="py-2 px-4 border-b">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($inscripcion->calificaciones as $calificacion)
                                            <tr>
                                                <td class="py-2 px-4 border-b">{{ $calificacion->descripcion }}</td>
                                                <td class="py-2 px-4 border-b">{{ $calificacion->valor_calificacion }}</td>
                                                <td class="py-2 px-4 border-b">
                                                    <form action="{{ route('docente.eliminar_calificacion', $calificacion) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Eliminar esta calificación?')">Eliminar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <p class="mt-2 font-bold">Promedio: {{ number_format($inscripcion->calificaciones->avg('valor_calificacion'), 2) }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>