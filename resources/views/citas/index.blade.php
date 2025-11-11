@extends('layouts.app')

@section('title', 'Gestión de Citas')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <!-- Header con título y botones -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    @if(auth()->user()->isPaciente())
                        <i class="fas fa-calendar-check text-blue-500 mr-2"></i>Mis Citas Médicas
                    @elseif(auth()->user()->isMedico())
                        <i class="fas fa-user-md text-green-500 mr-2"></i>Gestión de Citas
                    @else
                        <i class="fas fa-cogs text-purple-500 mr-2"></i>Gestión de Citas
                    @endif
                </h1>
                <p class="text-gray-600 mt-1">
                    @if(auth()->user()->isPaciente())
                        Consulta y gestiona todas tus citas médicas
                    @elseif(auth()->user()->isMedico())
                        Administra las citas de tus pacientes
                    @else
                        Administra todas las citas del sistema
                    @endif
                </p>
            </div>
            
            <div class="flex space-x-3">
                @if(auth()->user()->isPaciente() || auth()->user()->isMedico() || auth()->user()->isAdmin())
                <a href="{{ route('citas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-300 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    @if(auth()->user()->isPaciente())
                        Nueva Cita
                    @else
                        Crear Cita
                    @endif
                </a>
                @endif
                
                @if((auth()->user()->isMedico() || auth()->user()->isAdmin()) && route('pacientes.index'))
                <a href="{{ route('pacientes.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-300 flex items-center">
                    <i class="fas fa-users mr-2"></i>Pacientes
                </a>
                @endif
            </div>
        </div>

        <!-- Tarjetas de Estadísticas -->
        @if(auth()->user()->isMedico() && $citas->count() > 0)
        @php
            // Calcular estadísticas desde la colección paginada
            $citasCollection = $citas->getCollection();
            $citasHoy = $citasCollection->filter(function($cita) {
                return $cita->estado == 'confirmada' && $cita->fecha_hora->isToday();
            })->count();
            
            $citasPendientes = $citasCollection->where('estado', 'pendiente')->count();
            $citasCompletadas = $citasCollection->where('estado', 'completada')->count();
            $citasCanceladas = $citasCollection->where('estado', 'cancelada')->count();
            
            $proximasCitasCount = $citasCollection->filter(function($cita) {
                return $cita->fecha_hora >= now() && in_array($cita->estado, ['pendiente', 'confirmada']);
            })->count();
            
            $proximaCita = $citasCollection->filter(function($cita) {
                return $cita->fecha_hora >= now() && in_array($cita->estado, ['pendiente', 'confirmada']);
            })->sortBy('fecha_hora')->first();
            
            $pacientesAtendidosHoy = $citasCollection->filter(function($cita) {
                return $cita->estado == 'completada' && $cita->fecha_hora->isToday();
            })->count();
        @endphp
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white border-l-4 border-blue-500 rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <i class="fas fa-calendar-day text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Citas Hoy</p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $citasHoy }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-yellow-500 rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-3 rounded-full mr-4">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Pendientes</p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $citasPendientes }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-green-500 rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-full mr-4">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Completadas</p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $citasCompletadas }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-red-500 rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="bg-red-100 p-3 rounded-full mr-4">
                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Canceladas</p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $citasCanceladas }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Filtros Compactos -->
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <form method="GET" action="{{ route('citas.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <!-- Filtro Estado -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select name="estado" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">Todos</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="confirmada" {{ request('estado') == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                        <option value="completada" {{ request('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                        <option value="cancelada" {{ request('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>
                
                <!-- Filtro Fecha -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                    <input type="date" name="fecha" value="{{ request('fecha') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                
                <!-- Filtro Nombre -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        @if(auth()->user()->isMedico() || auth()->user()->isAdmin())
                            Paciente
                        @else
                            Médico
                        @endif
                    </label>
                    <input type="text" name="nombre" value="{{ request('nombre') }}" placeholder="Buscar por nombre..." class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                
                <!-- Botones -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold transition duration-300 flex items-center justify-center">
                        <i class="fas fa-filter mr-2"></i>Filtrar
                    </button>
                    <a href="{{ route('citas.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-md font-medium transition duration-300 flex items-center justify-center" title="Limpiar filtros">
                        <i class="fas fa-eraser"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Lista de Citas -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            @if($citas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha y Hora
                                </th>
                                @if(auth()->user()->isMedico() || auth()->user()->isAdmin())
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Paciente
                                </th>
                                @else
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Médico
                                </th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Especialidad
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tipo / Prioridad
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($citas as $cita)
                            <tr class="hover:bg-gray-50 transition duration-300">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                            <i class="fas fa-calendar text-blue-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $cita->fecha_hora->format('d/m/Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $cita->fecha_hora->format('H:i') }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ $cita->duracion }} min
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                @if(auth()->user()->isMedico() || auth()->user()->isAdmin())
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="bg-green-100 p-2 rounded-full mr-3">
                                            <i class="fas fa-user text-green-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $cita->paciente->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                <i class="fas fa-phone text-gray-400 mr-1"></i>{{ $cita->paciente->telefono }}
                                            </div>
                                            @if($cita->es_primera_vez)
                                            <div class="text-xs text-blue-600 font-medium">
                                                <i class="fas fa-star mr-1"></i>Primera vez
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                @else
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="bg-purple-100 p-2 rounded-full mr-3">
                                            <i class="fas fa-user-md text-purple-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                Dr. {{ $cita->medico->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $cita->medico->especialidad->nombre }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @endif
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="bg-orange-100 p-2 rounded-full mr-3">
                                            <i class="fas fa-stethoscope text-orange-600 text-sm"></i>
                                        </div>
                                        <span class="text-sm text-gray-900">{{ $cita->medico->especialidad->nombre }}</span>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 capitalize">
                                        @php
                                            $tiposCita = [
                                                'consulta' => 'Consulta',
                                                'control' => 'Control',
                                                'emergencia' => 'Emergencia',
                                                'seguimiento' => 'Seguimiento'
                                            ];
                                        @endphp
                                        {{ $tiposCita[$cita->tipo_cita] ?? $cita->tipo_cita }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-exclamation-circle 
                                            @if($cita->prioridad == 'urgente') text-red-500
                                            @elseif($cita->prioridad == 'alta') text-orange-500
                                            @elseif($cita->prioridad == 'normal') text-blue-500
                                            @else text-green-500 @endif mr-1">
                                        </i>
                                        <span class="capitalize">{{ $cita->prioridad }}</span>
                                    </div>
                                    @if($cita->motivo_consulta)
                                    <div class="text-xs text-gray-500 mt-1 truncate max-w-xs" title="{{ $cita->motivo_consulta }}">
                                        <i class="fas fa-comment-medical text-gray-400 mr-1"></i>
                                        {{ Str::limit($cita->motivo_consulta, 40) }}
                                    </div>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($cita->estado == 'pendiente') bg-yellow-100 text-yellow-800 border border-yellow-200
                                        @elseif($cita->estado == 'confirmada') bg-blue-100 text-blue-800 border border-blue-200
                                        @elseif($cita->estado == 'completada') bg-green-100 text-green-800 border border-green-200
                                        @else bg-red-100 text-red-800 border border-red-200 @endif">
                                        <i class="fas 
                                            @if($cita->estado == 'pendiente') fa-clock 
                                            @elseif($cita->estado == 'confirmada') fa-check 
                                            @elseif($cita->estado == 'completada') fa-check-double 
                                            @else fa-times @endif mr-1">
                                        </i>
                                        {{ ucfirst($cita->estado) }}
                                    </span>
                                    @if($cita->fecha_hora < now() && $cita->estado == 'pendiente')
                                    <div class="text-xs text-red-600 mt-1">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>Vencida
                                    </div>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if(auth()->user()->isMedico() || auth()->user()->isAdmin())
                                        <div class="flex space-x-1">
                                            <!-- Enlace para ver detalles -->
                                            <a href="{{ route('citas.show', $cita) }}" class="text-green-600 hover:text-green-900 p-2 rounded-full hover:bg-green-50 transition duration-300" title="Ver detalles completos">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <!-- Enlace para editar información médica -->
                                            <a href="{{ route('citas.edit', $cita) }}" class="text-blue-600 hover:text-blue-900 p-2 rounded-full hover:bg-blue-50 transition duration-300" title="Editar información médica">
                                                <i class="fas fa-notes-medical"></i>
                                            </a>
                                            
                                            <!-- Botones de estado -->
                                            @if($cita->estado == 'pendiente')
                                                <form action="{{ route('citas.update-status', $cita) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="estado" value="confirmada">
                                                    <button type="submit" class="text-blue-600 hover:text-blue-900 p-2 rounded-full hover:bg-blue-50 transition duration-300" title="Confirmar cita">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if($cita->estado == 'confirmada')
                                                <form action="{{ route('citas.update-status', $cita) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="estado" value="completada">
                                                    <button type="submit" class="text-green-600 hover:text-green-900 p-2 rounded-full hover:bg-green-50 transition duration-300" title="Marcar como completada">
                                                        <i class="fas fa-check-double"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if(in_array($cita->estado, ['pendiente', 'confirmada']))
                                                <form action="{{ route('citas.update-status', $cita) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="estado" value="cancelada">
                                                    <button type="submit" class="text-red-600 hover:text-red-900 p-2 rounded-full hover:bg-red-50 transition duration-300" title="Cancelar cita">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @else
                                        <!-- Para pacientes -->
                                        <div class="flex space-x-1">
                                            <a href="{{ route('citas.show', $cita) }}" class="text-blue-600 hover:text-blue-900 p-2 rounded-full hover:bg-blue-50 transition duration-300" title="Ver detalles completos">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if($cita->estado == 'pendiente')
                                                <form action="{{ route('citas.update-status', $cita) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="estado" value="cancelada">
                                                    <button type="submit" class="text-red-600 hover:text-red-900 p-2 rounded-full hover:bg-red-50 transition duration-300" title="Cancelar cita">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Información de la tabla -->
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <p class="text-sm text-gray-700">
                                Mostrando <span class="font-medium">{{ $citas->count() }}</span> 
                                de <span class="font-medium">{{ $citas->total() }}</span> citas
                            </p>
                            
                            @if(auth()->user()->isMedico() || auth()->user()->isAdmin())
                            <div class="flex space-x-4 text-sm text-gray-600">
                                @php
                                    $estados = $citas->getCollection()->groupBy('estado');
                                @endphp
                                @foreach($estados as $estado => $citasEstado)
                                    <span class="inline-flex items-center">
                                        <span class="w-3 h-3 rounded-full 
                                            @if($estado == 'pendiente') bg-yellow-400
                                            @elseif($estado == 'confirmada') bg-blue-400
                                            @elseif($estado == 'completada') bg-green-400
                                            @else bg-red-400 @endif mr-2"></span>
                                        {{ ucfirst($estado) }}: <span class="font-medium ml-1">{{ $citasEstado->count() }}</span>
                                    </span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        
                        <!-- Paginación -->
                        <div class="flex items-center space-x-2">
                            @if($citas->hasPages())
                            <div class="flex items-center space-x-1 bg-white rounded-lg border border-gray-200 p-1 shadow-sm">
                                @if($citas->onFirstPage())
                                <span class="px-3 py-1 text-gray-400 cursor-not-allowed rounded-md">
                                    <i class="fas fa-chevron-left mr-1"></i>
                                </span>
                                @else
                                <a href="{{ $citas->previousPageUrl() }}" class="px-3 py-1 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md transition duration-300 flex items-center">
                                    <i class="fas fa-chevron-left mr-1"></i>
                                </a>
                                @endif

                                <div class="flex space-x-1">
                                    @foreach($citas->getUrlRange(1, $citas->lastPage()) as $page => $url)
                                        @if($page == $citas->currentPage())
                                        <span class="px-3 py-1 bg-blue-600 text-white rounded-md font-medium">
                                            {{ $page }}
                                        </span>
                                        @else
                                        <a href="{{ $url }}" class="px-3 py-1 text-gray-700 hover:bg-gray-100 rounded-md transition duration-300">
                                            {{ $page }}
                                        </a>
                                        @endif
                                    @endforeach
                                </div>

                                @if($citas->hasMorePages())
                                <a href="{{ $citas->nextPageUrl() }}" class="px-3 py-1 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md transition duration-300 flex items-center">
                                    <i class="fas fa-chevron-right ml-1"></i>
                                </a>
                                @else
                                <span class="px-3 py-1 text-gray-400 cursor-not-allowed rounded-md">
                                    <i class="fas fa-chevron-right ml-1"></i>
                                </span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay citas registradas</h3>
                    <p class="text-gray-500 mb-4">
                        @if(auth()->user()->isPaciente())
                            No tienes citas programadas en este momento.
                        @else
                            No se encontraron citas con los filtros aplicados.
                        @endif
                    </p>
                    @if(auth()->user()->isPaciente() || auth()->user()->isMedico() || auth()->user()->isAdmin())
                        <a href="{{ route('citas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-300 inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            @if(auth()->user()->isPaciente())
                                Agendar Primera Cita
                            @else
                                Crear Primera Cita
                            @endif
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Información adicional para médicos -->
        @if(auth()->user()->isMedico() && $citas->count() > 0)
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg p-6">
                <div class="flex items-center">
                    <i class="fas fa-user-injured text-3xl mr-4 opacity-80"></i>
                    <div>
                        <p class="text-sm opacity-90">Pacientes Atendidos Hoy</p>
                        <p class="text-2xl font-bold">
                            {{ $pacientesAtendidosHoy }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg p-6">
                <div class="flex items-center">
                    <i class="fas fa-clock text-3xl mr-4 opacity-80"></i>
                    <div>
                        <p class="text-sm opacity-90">Próximas Citas</p>
                        <p class="text-2xl font-bold">
                            {{ $proximasCitasCount }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg p-6">
                <div class="flex items-center">
                    <i class="fas fa-calendar-check text-3xl mr-4 opacity-80"></i>
                    <div>
                        <p class="text-sm opacity-90">Próxima Cita</p>
                        <p class="text-lg font-bold">
                            @if($proximaCita)
                                {{ $proximaCita->fecha_hora->format('d/m H:i') }}
                            @else
                                No programada
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Mostrar confirmación antes de acciones importantes
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            if (form.action.includes('update-status')) {
                form.addEventListener('submit', function(e) {
                    const estado = this.querySelector('input[name="estado"]').value;
                    let mensaje = '';
                    
                    switch(estado) {
                        case 'confirmada':
                            mensaje = '¿Confirmar esta cita?';
                            break;
                        case 'completada':
                            mensaje = '¿Marcar cita como completada?';
                            break;
                        case 'cancelada':
                            mensaje = '¿Cancelar esta cita?';
                            break;
                    }
                    
                    if (mensaje && !confirm(mensaje)) {
                        e.preventDefault();
                    }
                });
            }
        });

        // Tooltips básicos
        const elementsWithTitle = document.querySelectorAll('[title]');
        elementsWithTitle.forEach(element => {
            element.addEventListener('mouseenter', function(e) {
                const title = this.getAttribute('title');
                if (title) {
                    // Tooltip simple nativo del navegador
                }
            });
        });
    });
</script>
@endpush
@endsection