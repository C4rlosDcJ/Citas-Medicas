<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Desactivar verificación de claves foráneas temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Limpiar tablas
        \App\Models\Role::truncate();
        \App\Models\Especialidad::truncate();
        \App\Models\User::truncate();
        \App\Models\Medico::truncate();
        \App\Models\Paciente::truncate();

        // Roles
        $roles = [
            ['nombre' => 'Administrador', 'descripcion' => 'Administrador del sistema'],
            ['nombre' => 'Médico', 'descripcion' => 'Personal médico'],
            ['nombre' => 'Paciente', 'descripcion' => 'Paciente del sistema'],
        ];

        foreach ($roles as $role) {
            \App\Models\Role::create($role);
        }

        // Especialidades
        $especialidades = [
            ['nombre' => 'Medicina General', 'descripcion' => 'Medicina general y familiar'],
            ['nombre' => 'Cardiología', 'descripcion' => 'Especialidad en corazón y sistema circulatorio'],
            ['nombre' => 'Pediatría', 'descripcion' => 'Medicina para niños y adolescentes'],
            ['nombre' => 'Ginecología', 'descripcion' => 'Salud femenina y reproductiva'],
            ['nombre' => 'Dermatología', 'descripcion' => 'Especialidad en piel y enfermedades cutáneas'],
        ];

        foreach ($especialidades as $especialidad) {
            \App\Models\Especialidad::create($especialidad);
        }

        // Usuario Administrador
        $admin = \App\Models\User::create([
            'name' => 'Administrador',
            'email' => 'admin@clinica.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
        ]);

        // Usuario Médico
        $medicoUser = \App\Models\User::create([
            'name' => 'Dr. Juan Pérez',
            'email' => 'medico@clinica.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
        ]);

        \App\Models\Medico::create([
            'user_id' => $medicoUser->id,
            'especialidad_id' => 1,
            'cedula_profesional' => 'MG123456',
            'telefono_consultorio' => '555-1234',
            'horario_atencion' => 'Lunes a Viernes: 8:00 - 16:00',
        ]);

        // Usuario Paciente
        $pacienteUser = \App\Models\User::create([
            'name' => 'María García',
            'email' => 'paciente@clinica.com',
            'password' => Hash::make('password'),
            'role_id' => 3,
        ]);

        \App\Models\Paciente::create([
            'user_id' => $pacienteUser->id,
            'fecha_nacimiento' => '1990-05-15',
            'telefono' => '555-5678',
            'direccion' => 'Calle Principal #123',
            'alergias' => 'Penicilina',
            'antecedentes_medicos' => 'Ninguno',
        ]);

        // Reactivar verificación de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}