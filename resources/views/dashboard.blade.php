@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Welcome Section -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-xl overflow-hidden">
                <div class="px-8 py-10 sm:px-12 sm:py-12">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div class="flex-1">
                            <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">
                                ¡Hola, {{ auth()->user()->name }}! 👋
                            </h1>
                            <p class="text-blue-100 text-lg">
                                @if(auth()->user()->isPaciente())
                                    Gestiona tus citas médicas y mantén tu salud al día
                                @elseif(auth()->user()->isMedico())
                                    Revisa tus citas programadas y pacientes del día
                                @else
                                    Panel de administración del sistema de citas
                                @endif
                            </p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="h-16 w-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-white text-2xl"></i>
                            </div>
                            <div class="text-white">
                                <p class="text-sm font-medium opacity-90">Hoy</p>
                                <p class="text-xl font-bold">{{ now()->format('d M') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @if(auth()->user()->isPaciente())
                <!-- Citas Pendientes -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                            </div>
                            <span class="text-sm font-medium text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Activas</span>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Citas Pendientes</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $citasPendientes ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-50 px-6 py-3">
                        <p class="text-xs text-blue-700">
                            <i class="fas fa-arrow-up mr-1"></i>
                            Próximas consultas
                        </p>
                    </div>
                </div>
                
                <!-- Citas Completadas -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-12 w-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                            <span class="text-sm font-medium text-green-600 bg-green-50 px-3 py-1 rounded-full">Listo</span>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Citas Completadas</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $citasCompletadas ?? 0 }}</p>
                    </div>
                    <div class="bg-green-50 px-6 py-3">
                        <p class="text-xs text-green-700">
                            <i class="fas fa-check mr-1"></i>
                            Historial médico
                        </p>
                    </div>
                </div>
            @endif

            @if(auth()->user()->isMedico())
                <!-- Citas del Día -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-12 w-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-clock text-purple-600 text-xl"></i>
                            </div>
                            <span class="text-sm font-medium text-purple-600 bg-purple-50 px-3 py-1 rounded-full">Hoy</span>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Citas del Día</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $citasHoy ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-50 px-6 py-3">
                        <p class="text-xs text-purple-700">
                            <i class="fas fa-user-clock mr-1"></i>
                            Pacientes programados
                        </p>
                    </div>
                </div>
            @endif

            <!-- Médicos Disponibles -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-12 w-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-md text-orange-600 text-xl"></i>
                        </div>
                        <span class="text-sm font-medium text-orange-600 bg-orange-50 px-3 py-1 rounded-full">Activo</span>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-1">Médicos Disponibles</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalMedicos ?? 0 }}</p>
                </div>
                <div class="bg-orange-50 px-6 py-3">
                    <p class="text-xs text-orange-700">
                        <i class="fas fa-stethoscope mr-1"></i>
                        Especialistas en línea
                    </p>
                </div>
            </div>

            <!-- Total Citas -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-12 w-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-indigo-600 text-xl"></i>
                        </div>
                        <span class="text-sm font-medium text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">Total</span>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-1">Total de Citas</h3>
                    <p class="text-3xl font-bold text-gray-900">
                        @php
                            $totalCitas = 0;
                            if(auth()->user()->isPaciente() && auth()->user()->paciente) {
                                $totalCitas = auth()->user()->paciente->citas()->count();
                            } elseif(auth()->user()->isMedico() && auth()->user()->medico) {
                                $totalCitas = auth()->user()->medico->citas()->count();
                            } elseif(auth()->user()->isAdmin()) {
                                $totalCitas = \App\Models\Cita::count();
                            }
                        @endphp
                        {{ $totalCitas }}
                    </p>
                </div>
                <div class="bg-indigo-50 px-6 py-3">
                    <p class="text-xs text-indigo-700">
                        <i class="fas fa-chart-line mr-1"></i>
                        Todas las consultas
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Acciones Rápidas</h2>
                    <i class="fas fa-bolt text-yellow-500 text-xl"></i>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @if(auth()->user()->isPaciente())
                        <!-- Agendar Nueva Cita -->
                        <a href="{{ route('citas.create') }}" class="group relative bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 p-6 rounded-xl text-white transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                            <div class="flex items-start justify-between mb-4">
                                <div class="h-12 w-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                    <i class="fas fa-plus text-2xl"></i>
                                </div>
                                <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                            </div>
                            <h3 class="font-bold text-lg mb-1">Agendar Nueva Cita</h3>
                            <p class="text-blue-100 text-sm">Solicitar una nueva consulta médica</p>
                        </a>
                        
                        <!-- Ver Mis Citas -->
                        <a href="{{ route('citas.index') }}" class="group relative bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 p-6 rounded-xl text-white transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                            <div class="flex items-start justify-between mb-4">
                                <div class="h-12 w-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                    <i class="fas fa-list text-2xl"></i>
                                </div>
                                <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                            </div>
                            <h3 class="font-bold text-lg mb-1">Ver Mis Citas</h3>
                            <p class="text-green-100 text-sm">Consultar tus citas programadas</p>
                        </a>
                    @endif

                    @if(auth()->user()->isMedico())
                        <!-- Citas de Hoy -->
                        <a href="{{ route('citas.index') }}" class="group relative bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 p-6 rounded-xl text-white transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                            <div class="flex items-start justify-between mb-4">
                                <div class="h-12 w-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                    <i class="fas fa-calendar-day text-2xl"></i>
                                </div>
                                <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                            </div>
                            <h3 class="font-bold text-lg mb-1">Citas de Hoy</h3>
                            <p class="text-purple-100 text-sm">Ver consultas programadas para hoy</p>
                        </a>

                        <!-- Todas las Citas -->
                        <a href="{{ route('citas.index') }}" class="group relative bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 p-6 rounded-xl text-white transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                            <div class="flex items-start justify-between mb-4">
                                <div class="h-12 w-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                    <i class="fas fa-list text-2xl"></i>
                                </div>
                                <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                            </div>
                            <h3 class="font-bold text-lg mb-1">Todas las Citas</h3>
                            <p class="text-blue-100 text-sm">Gestionar todas tus citas</p>
                        </a>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <!-- Gestión Completa -->
                        <a href="{{ route('citas.index') }}" class="group relative bg-gradient-to-br from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 p-6 rounded-xl text-white transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                            <div class="flex items-start justify-between mb-4">
                                <div class="h-12 w-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                    <i class="fas fa-cog text-2xl"></i>
                                </div>
                                <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                            </div>
                            <h3 class="font-bold text-lg mb-1">Gestión Completa</h3>
                            <p class="text-red-100 text-sm">Administrar todo el sistema</p>
                        </a>
                    @endif

                    <!-- Mi Perfil -->
                    <a href="#" class="group relative bg-gradient-to-br from-gray-700 to-gray-800 hover:from-gray-800 hover:to-gray-900 p-6 rounded-xl text-white transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                        <div class="flex items-start justify-between mb-4">
                            <div class="h-12 w-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-edit text-2xl"></i>
                            </div>
                            <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-1">Mi Perfil</h3>
                        <p class="text-gray-300 text-sm">Actualizar información personal</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Próximas Citas -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Próximas Citas</h3>
                    <i class="fas fa-calendar-plus text-blue-500"></i>
                </div>
                
                @php
                    $proximasCitas = [];
                    if(auth()->user()->isPaciente() && auth()->user()->paciente) {
                        $proximasCitas = auth()->user()->paciente->citas()
                            ->with('medico.user', 'medico.especialidad')
                            ->where('fecha_hora', '>=', now())
                            ->whereIn('estado', ['pendiente', 'confirmada'])
                            ->orderBy('fecha_hora')
                            ->take(3)
                            ->get();
                    } elseif(auth()->user()->isMedico() && auth()->user()->medico) {
                        $proximasCitas = auth()->user()->medico->citas()
                            ->with('paciente.user')
                            ->where('fecha_hora', '>=', now())
                            ->whereIn('estado', ['pendiente', 'confirmada'])
                            ->orderBy('fecha_hora')
                            ->take(3)
                            ->get();
                    }
                @endphp

                @if(count($proximasCitas) > 0)
                    <div class="space-y-4">
                        @foreach($proximasCitas as $cita)
                            <div class="group flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl hover:shadow-md transition-all duration-300 border border-gray-100">
                                <div class="flex items-center space-x-4">
                                    <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-user-md text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">
                                            @if(auth()->user()->isPaciente())
                                                Dr. {{ $cita->medico->user->name }}
                                            @else
                                                {{ $cita->paciente->user->name }}
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-600 flex items-center mt-1">
                                            <i class="fas fa-clock mr-2 text-xs"></i>
                                            {{ $cita->fecha_hora->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-3 py-1.5 text-xs font-bold rounded-full 
                                        @if($cita->estado == 'pendiente') bg-yellow-100 text-yellow-700
                                        @else bg-blue-100 text-blue-700 @endif">
                                        {{ ucfirst($cita->estado) }}
                                    </span>
                                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="h-20 w-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-calendar-times text-gray-400 text-3xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">No hay citas próximas</p>
                        <p class="text-sm text-gray-400 mt-1">Agenda una nueva consulta cuando lo necesites</p>
                    </div>
                @endif
            </div>

            <!-- Información del Usuario -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Mi Información</h3>
                    <i class="fas fa-id-card text-indigo-500"></i>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-indigo-50 rounded-xl">
                        <div class="h-12 w-12 bg-indigo-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-user text-indigo-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">Nombre</p>
                            <p class="font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl">
                        <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-envelope text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-semibold text-gray-900">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-purple-50 rounded-xl">
                        <div class="h-12 w-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-shield-alt text-purple-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">Rol</p>
                            <p class="font-semibold text-gray-900">{{ auth()->user()->role->nombre }}</p>
                        </div>
                    </div>

                    @if(auth()->user()->isPaciente() && auth()->user()->paciente)
                        <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-green-50 rounded-xl">
                            <div class="h-12 w-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-phone text-green-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-600">Teléfono</p>
                                <p class="font-semibold text-gray-900">{{ auth()->user()->paciente->telefono }}</p>
                            </div>
                        </div>
                    @endif

                    @if(auth()->user()->isMedico() && auth()->user()->medico)
                        <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-orange-50 rounded-xl">
                            <div class="h-12 w-12 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-stethoscope text-orange-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-600">Especialidad</p>
                                <p class="font-semibold text-gray-900">{{ auth()->user()->medico->especialidad->nombre }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection