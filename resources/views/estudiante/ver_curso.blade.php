<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Curso: ') . $materia->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('estudiante.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Volver a Mis Cursos</a>

                    <p><strong>Código:</strong> {{ $materia->codigo }}</p>
                    <p><strong>Docente:</strong> {{ $materia->docente->usuario->name }}</p>
                    <p><strong>Estado de Inscripción:</strong> {{ $inscripcion->estado }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Mis Calificaciones</h3>
                    @if($calificaciones->isEmpty())
                        <p>No hay calificaciones registradas.</p>
                    @else
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">Descripción</th>
                                    <th class="py-2 px-4 border-b">Calificación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calificaciones as $calificacion)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $calificacion->descripcion }}</td>
                                        <td class="py-2 px-4 border-b">{{ $calificacion->valor_calificacion }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4 p-4 bg-blue-100 rounded">
                            <p class="text-lg font-bold">Nota Final (Promedio): {{ number_format($calificaciones->avg('valor_calificacion'), 2) }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Mi Asistencia</h3>
                    @if($asistencias->isEmpty())
                        <p>No hay registros de asistencia.</p>
                    @else
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">Fecha</th>
                                    <th class="py-2 px-4 border-b">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($asistencias as $asistencia)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $asistencia->fecha }}</td>
                                        <td class="py-2 px-4 border-b">{{ $asistencia->estado }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>