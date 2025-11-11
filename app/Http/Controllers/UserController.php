<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Especialidad;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        // Solo administradores pueden ver la lista de usuarios
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta página.');
        }

        $users = User::with('role', 'medico.especialidad', 'paciente')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta página.');
        }

        $roles = Role::all();
        $especialidades = Especialidad::all();
        return view('users.create', compact('roles', 'especialidades'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }

        // Validación base para todos los usuarios
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => 'required|exists:roles,id',
            'telefono' => 'required|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'fecha_nacimiento' => 'required|date|before:today',
            'genero' => 'required|in:masculino,femenino,otro',
            'cedula' => 'nullable|string|max:20',
            'notas' => 'nullable|string|max:1000',
        ]);

        // Validaciones específicas por rol
        if ($request->role_id == 2) { // Médico
            $request->validate([
                'especialidad_id' => 'required|exists:especialidades,id',
                'cedula_profesional' => 'required|string|max:50|unique:medicos',
                'telefono_consultorio' => 'required|string|max:20',
                'horario_atencion' => 'required|string|max:255',
            ]);
        }

        if ($request->role_id == 3) { // Paciente
            $request->validate([
                'alergias' => 'nullable|string|max:500',
                'antecedentes_medicos' => 'nullable|string|max:1000',
            ]);
        }

        try {
            DB::beginTransaction();

            // Crear el usuario
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'genero' => $request->genero,
                'cedula' => $request->cedula,
                'notas' => $request->notas,
                'activo' => true,
            ]);

            // Crear registros específicos según el rol
            if ($request->role_id == 2) { // Médico
                Medico::create([
                    'user_id' => $user->id,
                    'especialidad_id' => $request->especialidad_id,
                    'cedula_profesional' => $request->cedula_profesional,
                    'telefono_consultorio' => $request->telefono_consultorio,
                    'horario_atencion' => $request->horario_atencion,
                ]);
            }

            if ($request->role_id == 3) { // Paciente
                Paciente::create([
                    'user_id' => $user->id,
                    'fecha_nacimiento' => $request->fecha_nacimiento,
                    'telefono' => $request->telefono,
                    'direccion' => $request->direccion,
                    'alergias' => $request->alergias,
                    'antecedentes_medicos' => $request->antecedentes_medicos,
                ]);
            }

            DB::commit();

            return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }

    public function show(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta página.');
        }

        $user->load('role', 'medico.especialidad', 'paciente');
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta página.');
        }

        $roles = Role::all();
        $especialidades = Especialidad::all();
        return view('users.edit', compact('user', 'roles', 'especialidades'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }

        // Validación base
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'telefono' => 'required|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'fecha_nacimiento' => 'required|date|before:today',
            'genero' => 'required|in:masculino,femenino,otro',
            'cedula' => 'nullable|string|max:20',
            'notas' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            // Actualizar usuario
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => $request->role_id,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'genero' => $request->genero,
                'cedula' => $request->cedula,
                'notas' => $request->notas,
            ]);

            // Actualizar contraseña si se proporcionó
            if ($request->filled('password')) {
                $request->validate([
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                ]);
                $user->update(['password' => Hash::make($request->password)]);
            }

            DB::commit();

            return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }

        // No permitir eliminar el propio usuario
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        try {
            DB::beginTransaction();
            
            // Eliminar registros relacionados primero
            if ($user->medico) {
                $user->medico->delete();
            }
            if ($user->paciente) {
                $user->paciente->delete();
            }
            
            $user->delete();
            
            DB::commit();

            return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }

    public function toggleStatus(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }

        // No permitir desactivar el propio usuario
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'No puedes desactivar tu propio usuario.');
        }

        $user->update(['activo' => !$user->activo]);

        $status = $user->activo ? 'activado' : 'desactivado';
        return redirect()->back()->with('success', "Usuario {$status} exitosamente.");
    }
}