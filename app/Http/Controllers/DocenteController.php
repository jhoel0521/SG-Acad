<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Calificacion;
use App\Models\Inscripcion;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocenteController extends Controller
{

    public function dashboard()
    {
        $docente = Auth::user()->perfilDocente;
        $materias = $docente->materias;

        return view('docente.dashboard', compact('materias'));
    }

    public function estudiantes(Materia $materia)
    {
        // Verificar que la materia pertenece al docente
        if ($materia->docente_id !== Auth::user()->perfilDocente->id) {
            abort(403);
        }

        $inscripciones = $materia->inscripciones()->with('estudiante.usuario')->get();

        return view('docente.estudiantes', compact('materia', 'inscripciones'));
    }

    public function tomarAsistencia(Materia $materia)
    {
        if ($materia->docente_id !== Auth::user()->perfilDocente->id) {
            abort(403);
        }

        $inscripciones = $materia->inscripciones()->with('estudiante.usuario')->get();
        $fecha = now()->toDateString(); // Hoy

        // Verificar si ya se tomó asistencia hoy
        $asistenciasHoy = Asistencia::whereHas('inscripcion', function ($q) use ($materia) {
            $q->where('materia_id', $materia->id);
        })->where('fecha', $fecha)->count();

        $yaTomada = $asistenciasHoy > 0;

        return view('docente.tomar_asistencia', compact('materia', 'inscripciones', 'fecha', 'yaTomada'));
    }

    public function guardarAsistencia(Request $request, Materia $materia)
    {
        if ($materia->docente_id !== Auth::user()->perfilDocente->id) {
            abort(403);
        }

        $fecha = $request->fecha;
        $asistencias = $request->asistencias; // array de inscripcion_id => estado

        // Verificar si ya existe para esta fecha
        $existe = Asistencia::whereHas('inscripcion', function ($q) use ($materia) {
            $q->where('materia_id', $materia->id);
        })->where('fecha', $fecha)->exists();

        if ($existe) {
            return back()->withErrors(['error' => 'La asistencia ya fue tomada para esta fecha.']);
        }

        foreach ($asistencias as $inscripcionId => $estado) {
            Asistencia::create([
                'inscripcion_id' => $inscripcionId,
                'fecha' => $fecha,
                'estado' => $estado,
            ]);
        }

        return back()->with('success', 'Asistencia guardada exitosamente.');
    }

    public function calificaciones(Materia $materia)
    {
        if ($materia->docente_id !== Auth::user()->perfilDocente->id) {
            abort(403);
        }

        $inscripciones = $materia->inscripciones()->with('estudiante.usuario', 'calificaciones')->get();

        return view('docente.calificaciones', compact('materia', 'inscripciones'));
    }

    public function guardarCalificaciones(Request $request, Materia $materia)
    {
        if ($materia->docente_id !== Auth::user()->perfilDocente->id) {
            abort(403);
        }

        $calificaciones = $request->calificaciones; // array de inscripcion_id => ['valor' => , 'descripcion' => ]

        foreach ($calificaciones as $inscripcionId => $data) {
            if (!empty($data['valor']) && !empty($data['descripcion'])) {
                Calificacion::create([
                    'inscripcion_id' => $inscripcionId,
                    'descripcion' => $data['descripcion'],
                    'valor_calificacion' => $data['valor']
                ]);
            }
        }

        return back()->with('success', 'Calificaciones guardadas exitosamente.');
    }

    public function eliminarCalificacion(Calificacion $calificacion)
    {
        $materia = $calificacion->inscripcion->materia;
        
        if ($materia->docente_id !== Auth::user()->perfilDocente->id) {
            abort(403);
        }

        $calificacion->delete();

        return back()->with('success', 'Calificación eliminada exitosamente.');
    }
}
