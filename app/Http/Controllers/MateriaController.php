<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriaController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Materia::class);

        $materias = Materia::with('docente.usuario')->get();
        
        // Si es estudiante, obtener sus inscripciones
        $inscripciones = [];
        if (Auth::user()->hasRole('estudiante')) {
            $inscripciones = Auth::user()->perfilEstudiante->inscripciones()->pluck('materia_id')->toArray();
        }

        return view('materias.index', compact('materias', 'inscripciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Materia::class);

        return view('materias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Materia::class);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255|unique:materias',
        ]);

        Materia::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'docente_id' => Auth::user()->perfilDocente->id,
        ]);

        return redirect()->route('materias.index')->with('success', 'Materia creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Materia $materia)
    {
        $this->authorize('view', $materia);

        return view('materias.show', compact('materia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materia $materia)
    {
        $this->authorize('update', $materia);

        return view('materias.edit', compact('materia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materia $materia)
    {
        $this->authorize('update', $materia);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255|unique:materias,codigo,' . $materia->id,
        ]);

        $materia->update($request->only(['nombre', 'codigo']));

        return redirect()->route('materias.index')->with('success', 'Materia actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materia $materia)
    {
        $this->authorize('delete', $materia);

        $materia->delete();

        return redirect()->route('materias.index')->with('success', 'Materia eliminada exitosamente.');
    }

    /**
     * Inscribir estudiante en una materia.
     */
    public function inscribir(Materia $materia)
    {
        if (!Auth::user()->hasRole('estudiante')) {
            abort(403, 'Solo estudiantes pueden inscribirse.');
        }

        $estudiante = Auth::user()->perfilEstudiante;

        // Verificar si ya está inscrito
        $yaInscrito = $estudiante->inscripciones()->where('materia_id', $materia->id)->exists();

        if ($yaInscrito) {
            return back()->withErrors(['error' => 'Ya estás inscrito en esta materia.']);
        }

        $estudiante->inscripciones()->create([
            'materia_id' => $materia->id,
            'estado' => 'cursando',
        ]);

        return back()->with('success', 'Te has inscrito exitosamente.');
    }

    /**
     * Desinscribir estudiante de una materia.
     */
    public function desinscribir(Materia $materia)
    {
        if (!Auth::user()->hasRole('estudiante')) {
            abort(403, 'Solo estudiantes pueden desinscribirse.');
        }

        $estudiante = Auth::user()->perfilEstudiante;
        $inscripcion = $estudiante->inscripciones()->where('materia_id', $materia->id)->first();

        if (!$inscripcion) {
            return back()->withErrors(['error' => 'No estás inscrito en esta materia.']);
        }

        $inscripcion->delete();

        return back()->with('success', 'Te has desinscrito exitosamente.');
    }
}
