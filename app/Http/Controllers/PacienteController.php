<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\User;

class PacienteController extends Controller
{
    public function index()
    {
        // Solo médicos y admin pueden ver la lista de pacientes
        if (auth()->user()->isPaciente()) {
            abort(403, 'No tienes permisos para acceder a esta página.');
        }

        $pacientes = Paciente::with('user')->get();
        return view('pacientes.index', compact('pacientes'));
    }
}