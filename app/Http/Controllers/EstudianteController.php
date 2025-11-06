<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstudianteController extends Controller
{
    public function dashboard()
    {
        $estudiante = Auth::user()->perfilEstudiante;
        $inscripciones = $estudiante->inscripciones()->with('materia.docente.usuario')->get();

        return view('estudiante.dashboard', compact('inscripciones'));
    }

    public function verCurso(Materia $materia)
    {
        // Verificar que el estudiante esté inscrito
        $inscripcion = Auth::user()->perfilEstudiante->inscripciones()->where('materia_id', $materia->id)->first();

        if (!$inscripcion) {
            abort(403, 'No estás inscrito en esta materia.');
        }

        $calificaciones = $inscripcion->calificaciones;
        $asistencias = $inscripcion->asistencias;

        return view('estudiante.ver_curso', compact('materia', 'inscripcion', 'calificaciones', 'asistencias'));
    }
}
