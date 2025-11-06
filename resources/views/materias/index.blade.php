<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Materias') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(auth()->user()->hasRole('docente'))
                        <a href="{{ route('materias.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                            Crear Nueva Materia
                        </a>
                    @else
                        <p class="text-gray-600 mb-4">Solo los docentes pueden crear nuevas materias.</p>
                    @endif

                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Nombre</th>
                                <th class="py-2 px-4 border-b">Código</th>
                                <th class="py-2 px-4 border-b">Docente</th>
                                <th class="py-2 px-4 border-b">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($materias as $materia)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $materia->nombre }}</td>
                                    <td class="py-2 px-4 border-b">{{ $materia->codigo }}</td>
                                    <td class="py-2 px-4 border-b">{{ $materia->docente->usuario->name }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('materias.show', $materia) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                        @if(auth()->user()->hasRole('docente') && $materia->docente_id == auth()->user()->perfilDocente->id)
                                            <a href="{{ route('materias.edit', $materia) }}" class="text-green-600 hover:text-green-900 ml-2">Editar</a>
                                            <form action="{{ route('materias.destroy', $materia) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 ml-2" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>