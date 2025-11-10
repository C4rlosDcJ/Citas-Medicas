<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Medico;
use App\Models\Paciente;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = [];

        if ($user->isPaciente() && $user->paciente) {
            $data['citasPendientes'] = $user->paciente->citas()->where('estado', 'pendiente')->count();
            $data['citasCompletadas'] = $user->paciente->citas()->where('estado', 'completada')->count();
        } elseif ($user->isMedico() && $user->medico) {
            $citas = $user->medico->citas;
            $data['citasHoy'] = $citas->filter(function($cita) {
                return $cita->estado == 'confirmada' && $cita->fecha_hora->isToday();
            })->count();
        } elseif ($user->isAdmin()) {
            $data['totalCitas'] = Cita::count();
            $data['citasHoy'] = Cita::whereDate('fecha_hora', today())->count();
        }

        $data['totalMedicos'] = Medico::count();
        $data['totalPacientes'] = Paciente::count();

        return view('dashboard', $data);
    }
}