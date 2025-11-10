<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Medico;
use App\Models\Especialidad;
use App\Models\Paciente;
use Illuminate\Support\Facades\Log;

class CitaController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $citas = [];

        if ($user->isPaciente() && $user->paciente) {
            $citas = $user->paciente->citas()->with('medico.user', 'medico.especialidad')->get();
        } elseif ($user->isMedico() && $user->medico) {
            $citas = $user->medico->citas()->with('paciente.user')->get();
        } elseif ($user->isAdmin()) {
            $citas = Cita::with('paciente.user', 'medico.user', 'medico.especialidad')->get();
        }

        return view('citas.index', compact('citas'));
    }

    public function create()
    {
        $especialidades = Especialidad::all();
        $medicos = Medico::with('user', 'especialidad')->get();
        
        // Si es médico, solo puede crear citas para sus pacientes
        $medicoId = null;
        if (auth()->user()->isMedico()) {
            $medicoId = auth()->user()->medico->id;
        }

        // Obtener pacientes para médicos y admin
        $pacientes = [];
        if (auth()->user()->isMedico() || auth()->user()->isAdmin()) {
            $pacientes = Paciente::with('user')->get();
        }

        return view('citas.create', compact('especialidades', 'medicos', 'pacientes', 'medicoId'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        // Validaciones base
        $request->validate([
            'medico_id' => 'required|exists:medicos,id',
            'fecha_hora' => 'required|date|after:now',
            'motivo_consulta' => 'required|string|max:500',
            'tipo_cita' => 'required|in:consulta,control,emergencia,seguimiento',
            'duracion' => 'required|in:30,45,60,90,120',
        ]);

        // Determinar el paciente_id según el rol
        if ($user->isPaciente()) {
            // Paciente crea cita para sí mismo
            if (!$user->paciente) {
                return redirect()->back()->with('error', 'No se encontró perfil de paciente.');
            }
            $pacienteId = $user->paciente->id;
        } elseif ($user->isMedico() || $user->isAdmin()) {
            // Médico o admin crea cita para un paciente específico
            $request->validate([
                'paciente_id' => 'required|exists:pacientes,id',
            ]);
            $pacienteId = $request->paciente_id;
        } else {
            return redirect()->back()->with('error', 'No tienes permisos para crear citas.');
        }

        // Verificar disponibilidad del médico
        $citaExistente = Cita::where('medico_id', $request->medico_id)
            ->where('fecha_hora', $request->fecha_hora)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->exists();

        if ($citaExistente) {
            return redirect()->back()->with('error', 'El médico ya tiene una cita programada en ese horario. Por favor, elige otro horario.');
        }

        // Crear la cita
        Cita::create([
            'paciente_id' => $pacienteId,
            'medico_id' => $request->medico_id,
            'fecha_hora' => $request->fecha_hora,
            'motivo_consulta' => $request->motivo_consulta,
            'tipo_cita' => $request->tipo_cita,
            'duracion' => $request->duracion,
            'prioridad' => $request->prioridad ?? 'normal',
            'sintomas' => $request->sintomas,
            'es_primera_vez' => $request->has('es_primera_vez'),
            'referido_por' => $request->referido_por,
            'alergias_notas' => $request->alergias_notas,
            'medicamentos_actuales' => $request->medicamentos_actuales,
            'notas' => $request->notas,
            'estado' => 'pendiente',
        ]);

        $mensaje = $user->isPaciente() 
            ? 'Cita agendada exitosamente.' 
            : 'Cita creada para el paciente exitosamente.';

        return redirect()->route('citas.index')->with('success', $mensaje);
    }

    public function show(Cita $cita)
    {
        // Verificar que el usuario tiene permiso para ver esta cita
        if (auth()->user()->isPaciente() && auth()->user()->paciente->id !== $cita->paciente_id) {
            abort(403, 'No tienes permiso para ver esta cita.');
        }
        if (auth()->user()->isMedico() && auth()->user()->medico->id !== $cita->medico_id) {
            abort(403, 'No tienes permiso para ver esta cita.');
        }

        $cita->load('paciente.user', 'medico.user', 'medico.especialidad');
        return view('citas.show', compact('cita'));
    }

    public function edit(Cita $cita)
    {
        // Verificar que el usuario es médico y tiene permiso para editar esta cita
        if (auth()->user()->isMedico() && auth()->user()->medico->id !== $cita->medico_id) {
            abort(403, 'No tienes permiso para editar esta cita.');
        }

        $cita->load('paciente.user');
        return view('citas.edit', compact('cita'));
    }

    public function updateMedical(Request $request, Cita $cita)
    {
        // Debug inicial
        Log::info('=== INICIANDO ACTUALIZACIÓN MÉDICA ===');
        Log::info('Cita ID: ' . $cita->id);
        Log::info('Datos recibidos:', $request->all());
        Log::info('Action: ' . $request->input('action', 'NO RECIBIDO'));

        // Verificar permisos
        if (auth()->user()->isMedico() && auth()->user()->medico->id !== $cita->medico_id) {
            abort(403, 'No tienes permiso para actualizar esta cita.');
        }

        // Validaciones
        $request->validate([
            'temperatura' => 'nullable|numeric|min:35|max:42',
            'presion_arterial_sistolica' => 'nullable|integer|min:60|max:250',
            'presion_arterial_diastolica' => 'nullable|integer|min:40|max:150',
            'frecuencia_cardiaca' => 'nullable|integer|min:30|max:200',
            'frecuencia_respiratoria' => 'nullable|integer|min:8|max:60',
            'peso' => 'nullable|numeric|min:1|max:300',
            'altura' => 'nullable|numeric|min:0.5|max:2.5',
            'proxima_cita' => 'nullable|date|after:today',
            'diagnostico' => 'nullable|string|max:1000',
            'tratamiento' => 'nullable|string|max:1000',
            'medicamentos_recetados' => 'nullable|string|max:1000',
            'recomendaciones' => 'nullable|string|max:1000',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        // Calcular IMC
        $imc = null;
        if ($request->peso && $request->altura && $request->altura > 0) {
            $imc = $request->peso / ($request->altura * $request->altura);
            Log::info('IMC calculado: ' . $imc);
        }

        // Preparar datos
        $datosActualizacion = [
            'diagnostico' => $request->diagnostico,
            'tratamiento' => $request->tratamiento,
            'medicamentos_recetados' => $request->medicamentos_recetados,
            'recomendaciones' => $request->recomendaciones,
            'observaciones' => $request->observaciones,
            'seguimiento' => $request->seguimiento,
            'proxima_cita' => $request->proxima_cita,
            'temperatura' => $request->temperatura,
            'presion_arterial_sistolica' => $request->presion_arterial_sistolica,
            'presion_arterial_diastolica' => $request->presion_arterial_diastolica,
            'frecuencia_cardiaca' => $request->frecuencia_cardiaca,
            'frecuencia_respiratoria' => $request->frecuencia_respiratoria,
            'peso' => $request->peso,
            'altura' => $request->altura,
            'imc' => $imc,
        ];

        try {
            Log::info('Actualizando cita con datos:', $datosActualizacion);

            // Actualizar información médica
            $cita->update($datosActualizacion);
            Log::info('✅ Información médica actualizada');

            // Manejar acción del botón
            $action = $request->input('action');
            
            if ($action === 'completar') {
                $cita->update(['estado' => 'completada']);
                Log::info('✅ Cita marcada como COMPLETADA');
                
                return redirect()->route('citas.show', $cita)
                    ->with('success', 'Información médica guardada y cita completada exitosamente.');
            
            } else {
                Log::info('✅ Solo se guardó información médica');
                return redirect()->route('citas.show', $cita)
                    ->with('success', 'Información médica guardada correctamente.');
            }

        } catch (\Exception $e) {
            Log::error('❌ Error al actualizar cita: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Error al guardar la información: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function updateStatus(Request $request, Cita $cita)
    {
        if (auth()->user()->isMedico() || auth()->user()->isAdmin()) {
            $request->validate([
                'estado' => 'required|in:confirmada,completada,cancelada',
                'notas' => 'nullable|string|max:1000',
            ]);

            $cita->update([
                'estado' => $request->estado,
                'notas' => $request->notas,
            ]);

            return back()->with('success', 'Estado de la cita actualizado.');
        }

        // Pacientes solo pueden cancelar sus propias citas pendientes
        if (auth()->user()->isPaciente() && 
            auth()->user()->paciente && 
            auth()->user()->paciente->id === $cita->paciente_id &&
            $cita->estado === 'pendiente' &&
            $request->estado === 'cancelada') {
            
            $cita->update([
                'estado' => 'cancelada',
            ]);

            return back()->with('success', 'Cita cancelada exitosamente.');
        }

        return back()->with('error', 'No tienes permisos para esta acción.');
    }

    public function destroy(Cita $cita)
    {
        // Solo admin puede eliminar citas
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para eliminar citas.');
        }

        $cita->delete();

        return redirect()->route('citas.index')
            ->with('success', 'Cita eliminada exitosamente.');
    }
}