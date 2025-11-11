@extends('layouts.app')

@section('title', 'Detalles del Usuario')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-user-circle text-purple-500 mr-2"></i>Detalles del Usuario
            </h1>
            <div class="flex space-x-2">
                <a href="{{ route('users.edit', $user) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-300">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
                <a href="{{ route('users.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-semibold transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna Principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Información Personal -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user text-blue-500 mr-2"></i>
                        Información Personal
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nombre Completo</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Email</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">CURP</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $user->cedula ?? 'No especificada' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Fecha de Nacimiento</label>
                            <p class="mt-1 text-lg text-gray-900">
                                @if($user->fecha_nacimiento)
                                    {{ \Carbon\Carbon::parse($user->fecha_nacimiento)->format('d/m/Y') }}
                                    <span class="text-sm text-gray-500">({{ \Carbon\Carbon::parse($user->fecha_nacimiento)->age }} años)</span>
                                @else
                                    No especificada
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Género</label>
                            <p class="mt-1 text-lg text-gray-900 capitalize">{{ $user->genero ?? 'No especificado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Estado</label>
                            <p class="mt-1">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                    @if($user->activo) bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $user->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Información de Contacto -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-address-book text-green-500 mr-2"></i>
                        Información de Contacto
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Teléfono</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $user->telefono ?? 'No especificado' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500">Dirección</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $user->direccion ?? 'No especificada' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Información Específica por Rol -->
                @if($user->isMedico() && $user->medico)
                <div class="bg-white shadow-sm rounded-lg p-6 border-l-4 border-blue-500">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user-md text-blue-500 mr-2"></i>
                        Información Médica
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Especialidad</label>
                            <p class="mt-1 text-lg text-gray-900">
                                {{ $user->medico->especialidad->nombre ?? 'No especificada' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Cédula Profesional</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $user->medico->cedula_profesional }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Teléfono Consultorio</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $user->medico->telefono_consultorio }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Horario de Atención</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $user->medico->horario_atencion }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($user->isPaciente() && $user->paciente)
                <div class="bg-white shadow-sm rounded-lg p-6 border-l-4 border-green-500">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-file-medical text-green-500 mr-2"></i>
                        Información Médica del Paciente
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Alergias Conocidas</label>
                            <p class="mt-1 text-gray-900">
                                {{ $user->paciente->alergias ?? 'Sin alergias registradas' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Antecedentes Médicos</label>
                            <p class="mt-1 text-gray-900">
                                {{ $user->paciente->antecedentes_medicos ?? 'Sin antecedentes registrados' }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Notas -->
                @if($user->notas)
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-sticky-note text-yellow-500 mr-2"></i>
                        Notas Adicionales
                    </h2>
                    <p class="text-gray-900">{{ $user->notas }}</p>
                </div>
                @endif
            </div>

            <!-- Columna Lateral -->
            <div class="space-y-6">
                <!-- Tarjeta de Resumen -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 shadow-lg rounded-lg p-6 text-white">
                    <div class="text-center">
                        <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center mb-4">
                            <i class="fas {{ $user->role_id == 1 ? 'fa-user-shield text-purple-600' : ($user->role_id == 2 ? 'fa-user-md text-blue-600' : 'fa-user-injured text-green-600') }} text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">{{ $user->name }}</h3>
                        <p class="text-purple-100 mb-4">{{ $user->role->nombre }}</p>
                        @if($user->id === auth()->id())
                        <span class="inline-block bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-sm font-semibold">
                            Este eres tú
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Información del Sistema -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-gray-500 mr-2"></i>
                        Información del Sistema
                    </h2>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Fecha de Registro</label>
                            <p class="mt-1 text-gray-900">
                                {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'No disponible' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Última Actualización</label>
                            <p class="mt-1 text-gray-900">
                                {{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : 'No disponible' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">ID del Usuario</label>
                            <p class="mt-1 text-gray-900">#{{ $user->id }}</p>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                        Acciones Rápidas
                    </h2>
                    <div class="space-y-2">
                        <a href="{{ route('users.edit', $user) }}" class="block w-full bg-green-500 hover:bg-green-600 text-white text-center px-4 py-2 rounded-lg font-medium transition duration-300">
                            <i class="fas fa-edit mr-2"></i>Editar Usuario
                        </a>
                        
                        @if($user->id !== auth()->id())
                        <form action="{{ route('users.toggle-status', $user) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="block w-full bg-{{ $user->activo ? 'yellow' : 'green' }}-500 hover:bg-{{ $user->activo ? 'yellow' : 'green' }}-600 text-white text-center px-4 py-2 rounded-lg font-medium transition duration-300">
                                <i class="fas {{ $user->activo ? 'fa-pause' : 'fa-play' }} mr-2"></i>
                                {{ $user->activo ? 'Desactivar' : 'Activar' }} Usuario
                            </button>
                        </form>

                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este usuario? Esta acción no se puede deshacer.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="block w-full bg-red-500 hover:bg-red-600 text-white text-center px-4 py-2 rounded-lg font-medium transition duration-300">
                                <i class="fas fa-trash mr-2"></i>Eliminar Usuario
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection