<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tomar Asistencia - ') . $materia->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('docente.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Volver al Dashboard</a>

                    @if($yaTomada)
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                            La asistencia ya fue tomada para hoy ({{ $fecha }}). No se puede editar.
                        </div>
                    @else
                        <form method="POST" action="{{ route('docente.guardar_asistencia', $materia) }}">
                            @csrf
                            <input type="hidden" name="fecha" value="{{ $fecha }}">

                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b">Estudiante</th>
                                        <th class="py-2 px-4 border-b">Asistencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inscripciones as $inscripcion)
                                        <tr>
                                            <td class="py-2 px-4 border-b">{{ $inscripcion->estudiante->usuario->name }}</td>
                                            <td class="py-2 px-4 border-b">
                                                <select name="asistencias[{{ $inscripcion->id }}]" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                    <option value="presente">Presente</option>
                                                    <option value="ausente">Ausente</option>
                                                    <option value="licencia">Licencia</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-4">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Guardar Asistencia
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>