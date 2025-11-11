@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header elegante -->
        <div class="mb-12">
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-primary-600/10 to-primary-700/10 rounded-3xl blur-xl"></div>
                <div class="relative bg-white/80 backdrop-blur-sm border border-white/20 rounded-2xl p-8 shadow-sm">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-user-md text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-primary-800 bg-clip-text text-transparent mb-2">
                                        Hola, {{ auth()->user()->name }}
                                    </h1>
                                    <p class="text-gray-600 text-lg font-medium">
                                        {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                                    </p>
                                </div>
                            </div>
                            <p class="text-gray-500 text-sm max-w-2xl">
                                @if(auth()->user()->isPaciente())
                                    Gestiona tu salud de manera proactiva. Monitorea tus citas y mantén un historial médico actualizado.
                                @elseif(auth()->user()->isMedico())
                                    Optimiza tu agenda médica. Revisa pacientes programados y mantén un flujo de trabajo eficiente.
                                @else
                                    Supervisa el sistema completo. Gestiona usuarios, citas y reportes del centro médico.
                                @endif
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row lg:flex-col gap-3">
                            @if(auth()->user()->isPaciente())
                                <a href="{{ route('citas.create') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-xl hover:from-primary-700 hover:to-primary-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <i class="fas fa-plus mr-3 text-lg"></i>
                                    <span class="text-lg">Nueva cita</span>
                                </a>
                            @endif
                            <a href="{{ route('citas.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-200 hover:border-primary-300 hover:bg-primary-50 transition-all duration-300 shadow-sm hover:shadow-md">
                                <i class="fas fa-list mr-3 text-lg"></i>
                                <span class="text-lg">Citas</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            @if(auth()->user()->isPaciente())
                <!-- Citas Pendientes -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-primary-600 to-primary-700 rounded-2xl blur opacity-10 group-hover:opacity-20 transition duration-300"></div>
                    <div class="relative bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:border-primary-100 transition-all duration-300">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-calendar-check text-white text-xl"></i>
                                </div>
                                <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Pendientes</span>
                            </div>
                            <div class="w-3 h-3 bg-primary-400 rounded-full animate-pulse"></div>
                        </div>
                        <div class="space-y-2">
                            <p class="text-4xl font-bold text-gray-900">{{ $citasPendientes ?? 0 }}</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-clock mr-2 text-primary-500"></i>
                                <span>Citas por confirmar</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Citas Completadas -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl blur opacity-10 group-hover:opacity-20 transition duration-300"></div>
                    <div class="relative bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:border-green-100 transition-all duration-300">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-check-circle text-white text-xl"></i>
                                </div>
                                <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Completadas</span>
                            </div>
                            <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                        </div>
                        <div class="space-y-2">
                            <p class="text-4xl font-bold text-gray-900">{{ $citasCompletadas ?? 0 }}</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-history mr-2 text-green-500"></i>
                                <span>Consultas realizadas</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(auth()->user()->isMedico())
                <!-- Citas del Día -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl blur opacity-10 group-hover:opacity-20 transition duration-300"></div>
                    <div class="relative bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:border-purple-100 transition-all duration-300">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-clock text-white text-xl"></i>
                                </div>
                                <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Hoy</span>
                            </div>
                            <div class="w-3 h-3 bg-purple-400 rounded-full animate-pulse"></div>
                        </div>
                        <div class="space-y-2">
                            <p class="text-4xl font-bold text-gray-900">{{ $citasHoy ?? 0 }}</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-users mr-2 text-purple-500"></i>
                                <span>Pacientes programados</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Médicos Disponibles -->
            <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-r from-orange-600 to-amber-600 rounded-2xl blur opacity-10 group-hover:opacity-20 transition duration-300"></div>
                <div class="relative bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:border-orange-100 transition-all duration-300">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-user-md text-white text-xl"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Médicos</span>
                        </div>
                        <div class="w-3 h-3 bg-orange-400 rounded-full"></div>
                    </div>
                    <div class="space-y-2">
                        <p class="text-4xl font-bold text-gray-900">{{ $totalMedicos ?? 0 }}</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-stethoscope mr-2 text-orange-500"></i>
                            <span>Especialistas activos</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Citas -->
            <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-blue-600 rounded-2xl blur opacity-10 group-hover:opacity-20 transition duration-300"></div>
                <div class="relative bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:border-indigo-100 transition-all duration-300">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-calendar-alt text-white text-xl"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total</span>
                        </div>
                        <div class="w-3 h-3 bg-indigo-400 rounded-full"></div>
                    </div>
                    <div class="space-y-2">
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
                        <p class="text-4xl font-bold text-gray-900">{{ $totalCitas }}</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-chart-bar mr-2 text-indigo-500"></i>
                            <span>Todas las citas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Header con gradiente -->
                    <div class="bg-gradient-to-r from-gray-50 to-primary-50 px-8 py-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-calendar-plus text-white text-lg"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">Próximas citas</h2>
                                    <p class="text-sm text-gray-600">Tus consultas programadas</p>
                                </div>
                            </div>
                            <a href="{{ route('citas.index') }}" class="group flex items-center space-x-2 px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border border-gray-300 hover:border-primary-300 hover:bg-primary-50 transition-all duration-300 shadow-sm">
                                <span>Ver todas</span>
                                <i class="fas fa-arrow-right text-sm transform group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-8">
                        @php
                            $proximasCitas = [];
                            if(auth()->user()->isPaciente() && auth()->user()->paciente) {
                                $proximasCitas = auth()->user()->paciente->citas()
                                    ->with('medico.user', 'medico.especialidad')
                                    ->where('fecha_hora', '>=', now())
                                    ->whereIn('estado', ['pendiente', 'confirmada'])
                                    ->orderBy('fecha_hora')
                                    ->take(5)
                                    ->get();
                            } elseif(auth()->user()->isMedico() && auth()->user()->medico) {
                                $proximasCitas = auth()->user()->medico->citas()
                                    ->with('paciente.user')
                                    ->where('fecha_hora', '>=', now())
                                    ->whereIn('estado', ['pendiente', 'confirmada'])
                                    ->orderBy('fecha_hora')
                                    ->take(5)
                                    ->get();
                            }
                        @endphp

                        @if(count($proximasCitas) > 0)
                            <div class="space-y-4">
                                @foreach($proximasCitas as $cita)
                                    <a href="{{ route('citas.show', $cita->id) }}" class="block group">
                                        <div class="flex items-center justify-between p-6 bg-gradient-to-r from-white to-primary-50/50 border-2 border-transparent rounded-2xl hover:border-primary-200 hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                                            <div class="flex items-center space-x-6 flex-1">
                                                <div class="relative">
                                                    <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl flex items-center justify-center shadow-md">
                                                        <i class="fas fa-user-md text-primary-600 text-xl"></i>
                                                    </div>
                                                    @if($cita->prioridad == 'alta')
                                                        <div class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center shadow-lg">
                                                            <i class="fas fa-exclamation text-white text-xs"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center space-x-3 mb-2">
                                                        <p class="text-lg font-semibold text-gray-900 truncate">
                                                            @if(auth()->user()->isPaciente())
                                                                Dr. {{ $cita->medico->user->name }}
                                                            @else
                                                                {{ $cita->paciente->user->name }}
                                                            @endif
                                                        </p>
                                                        <span class="px-3 py-1 text-xs font-bold rounded-full
                                                            @if($cita->estado == 'pendiente') 
                                                                bg-yellow-100 text-yellow-700 border border-yellow-200
                                                            @else 
                                                                bg-primary-100 text-primary-700 border border-primary-200
                                                            @endif">
                                                            {{ ucfirst($cita->estado) }}
                                                        </span>
                                                    </div>
                                                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                                                        <span class="flex items-center space-x-2">
                                                            <i class="far fa-calendar text-primary-500"></i>
                                                            <span>{{ $cita->fecha_hora->format('d/m/Y') }}</span>
                                                        </span>
                                                        <span class="flex items-center space-x-2">
                                                            <i class="far fa-clock text-purple-500"></i>
                                                            <span>{{ $cita->fecha_hora->format('H:i') }}</span>
                                                        </span>
                                                        @if(auth()->user()->isPaciente())
                                                            <span class="flex items-center space-x-2">
                                                                <i class="fas fa-stethoscope text-green-500"></i>
                                                                <span>{{ $cita->medico->especialidad->nombre }}</span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-4">
                                                <div class="text-right">
                                                    <div class="text-sm font-medium text-gray-500">En</div>
                                                    <div class="text-lg font-bold text-primary-600 time-difference" data-datetime="{{ $cita->fecha_hora }}">
                                                        {{ $cita->fecha_hora->diffForHumans() }}
                                                    </div>
                                                </div>
                                                <i class="fas fa-chevron-right text-gray-400 text-lg transform group-hover:translate-x-2 transition-transform duration-300"></i>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-16">
                                <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                                    <i class="fas fa-calendar-times text-gray-400 text-4xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">No hay citas programadas</h3>
                                <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto">
                                    @if(auth()->user()->isPaciente())
                                        Agenda tu primera consulta médica y comienza a cuidar de tu salud
                                    @else
                                        No tienes citas programadas en este momento
                                    @endif
                                </p>
                                @if(auth()->user()->isPaciente())
                                    <a href="{{ route('citas.create') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-2xl hover:from-primary-700 hover:to-primary-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <i class="fas fa-plus mr-3 text-lg"></i>
                                        <span class="text-lg">Agendar primera cita</span>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar - Acciones rápidas (1/3) -->
            <div class="space-y-8">
                
                <!-- Acciones rápidas -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-bolt text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Acciones rápidas</h3>
                            <p class="text-sm text-gray-600">Accesos directos</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @if(auth()->user()->isPaciente())
                            <a href="{{ route('citas.create') }}" class="group flex items-center justify-between p-5 bg-gradient-to-r from-primary-50 to-primary-100/50 border-2 border-primary-200 rounded-2xl hover:border-primary-300 hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-md">
                                        <i class="fas fa-plus text-primary-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-gray-900 block">Nueva cita</span>
                                        <span class="text-sm text-gray-600">Agendar consulta</span>
                                    </div>
                                </div>
                                <i class="fas fa-arrow-right text-primary-600 text-lg transform group-hover:translate-x-2 transition-transform duration-300"></i>
                            </a>
                            
                            <a href="{{ route('citas.index') }}" class="group flex items-center justify-between p-5 bg-gradient-to-r from-green-50 to-green-100/50 border-2 border-green-200 rounded-2xl hover:border-green-300 hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-md">
                                        <i class="fas fa-list text-green-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-gray-900 block">Mis citas</span>
                                        <span class="text-sm text-gray-600">Ver historial</span>
                                    </div>
                                </div>
                                <i class="fas fa-arrow-right text-green-600 text-lg transform group-hover:translate-x-2 transition-transform duration-300"></i>
                            </a>
                        @endif

                        @if(auth()->user()->isMedico())
                            <a href="{{ route('citas.index') }}" class="group flex items-center justify-between p-5 bg-gradient-to-r from-purple-50 to-purple-100/50 border-2 border-purple-200 rounded-2xl hover:border-purple-300 hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-md">
                                        <i class="fas fa-calendar-day text-purple-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-gray-900 block">Citas de hoy</span>
                                        <span class="text-sm text-gray-600">Agenda diaria</span>
                                    </div>
                                </div>
                                <i class="fas fa-arrow-right text-purple-600 text-lg transform group-hover:translate-x-2 transition-transform duration-300"></i>
                            </a>

                            <a href="{{ route('citas.index') }}" class="group flex items-center justify-between p-5 bg-gradient-to-r from-primary-50 to-primary-100/50 border-2 border-primary-200 rounded-2xl hover:border-primary-300 hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-md">
                                        <i class="fas fa-list text-primary-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-gray-900 block">Todas las citas</span>
                                        <span class="text-sm text-gray-600">Gestión completa</span>
                                    </div>
                                </div>
                                <i class="fas fa-arrow-right text-primary-600 text-lg transform group-hover:translate-x-2 transition-transform duration-300"></i>
                            </a>
                        @endif

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('citas.index') }}" class="group flex items-center justify-between p-5 bg-gradient-to-r from-red-50 to-red-100/50 border-2 border-red-200 rounded-2xl hover:border-red-300 hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-md">
                                        <i class="fas fa-cog text-red-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-gray-900 block">Administrar</span>
                                        <span class="text-sm text-gray-600">Panel completo</span>
                                    </div>
                                </div>
                                <i class="fas fa-arrow-right text-red-600 text-lg transform group-hover:translate-x-2 transition-transform duration-300"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function formatTimeDifference(dateTime) {
        const now = new Date();
        const target = new Date(dateTime);
        const diffMs = target - now;
        
        if (diffMs <= 0) return 'Ahora';
        
        const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
        const diffHours = Math.floor((diffMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const diffMinutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
        
        let parts = [];
        
        if (diffDays > 0) {
            parts.push(`${diffDays} ${diffDays === 1 ? 'día' : 'días'}`);
        }
        
        if (diffHours > 0) {
            parts.push(`${diffHours} ${diffHours === 1 ? 'hora' : 'horas'}`);
        }
        
        if (diffMinutes > 0 && diffDays === 0) {
            parts.push(`${diffMinutes} ${diffMinutes === 1 ? 'minuto' : 'minutos'}`);
        }
        
        if (parts.length === 0) {
            return 'En menos de 1 minuto';
        }
        
        return 'En ' + parts.join(' y ');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const timeElements = document.querySelectorAll('.time-difference');
        timeElements.forEach(element => {
            const dateTime = element.getAttribute('data-datetime');
            if (dateTime) {
                element.textContent = formatTimeDifference(dateTime);
            }
        });
    });
</script>
@endpush

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
    }
    
    .floating {
        animation: float 3s ease-in-out infinite;
    }
    
    .scroll-smooth {
        scroll-behavior: smooth;
    }
    
    .hover-lift:hover {
        transform: translateY(-2px);
        transition: transform 0.2s ease;
    }
</style>
@endsection