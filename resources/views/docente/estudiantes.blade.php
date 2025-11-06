<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Estudiantes en ') . $materia->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('docente.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Volver al Dashboard</a>

                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Nombre</th>
                                <th class="py-2 px-4 border-b">Email</th>
                                <th class="py-2 px-4 border-b">Carrera</th>
                                <th class="py-2 px-4 border-b">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inscripciones as $inscripcion)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $inscripcion->estudiante->usuario->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $inscripcion->estudiante->usuario->email }}</td>
                                    <td class="py-2 px-4 border-b">{{ $inscripcion->estudiante->carrera }}</td>
                                    <td class="py-2 px-4 border-b">{{ $inscripcion->estado }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>