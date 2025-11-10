@extends('layouts.app')

@section('title', 'Detalles de la Cita')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <!-- Header de la cita -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">
                        @if(auth()->user()->isPaciente())
                            <i class="fas fa-calendar-check text-blue-500 mr-2"></i>Detalles de Mi Cita
                        @else
                            <i class="fas fa-calendar-alt text-green-500 mr-2"></i>Detalles de la Cita
                        @endif
                    </h1>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-user-md text-blue-500 mr-2"></i>
                            <span><strong>Médico:</strong> Dr. {{ $cita->medico->user->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-user-injured text-green-500 mr-2"></i>
                            <span><strong>Paciente:</strong> {{ $cita->paciente->user->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar text-purple-500 mr-2"></i>
                            <span><strong>Fecha:</strong> {{ $cita->fecha_hora->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col items-end space-y-2">
                    <span class="px-3 py-1 text-sm font-semibold rounded-full 
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
                    <a href="{{ route('citas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md font-medium text-sm transition duration-300">
                        <i class="fas fa-arrow-left mr-1"></i>Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna 1: Información General -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Información de la Cita - TARJETA MÁS COMPACTA -->
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2 text-sm"></i>
                        Información de la Cita
                    </h2>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Especialidad</label>
                            <p class="text-gray-900 bg-gray-50 p-2 rounded flex items-center text-xs">
                                <i class="fas fa-stethoscope text-orange-500 mr-2 text-xs"></i>
                                {{ $cita->medico->especialidad->nombre }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Tipo de Cita</label>
                            <p class="text-gray-900 bg-gray-50 p-2 rounded flex items-center text-xs">
                                <i class="fas fa-tag text-purple-500 mr-2 text-xs"></i>
                                @php
                                    $tiposCita = [
                                        'consulta' => 'Consulta General',
                                        'control' => 'Control',
                                        'emergencia' => 'Emergencia',
                                        'seguimiento' => 'Seguimiento'
                                    ];
                                @endphp
                                {{ $tiposCita[$cita->tipo_cita] ?? $cita->tipo_cita }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Duración</label>
                            <p class="text-gray-900 bg-gray-50 p-2 rounded flex items-center text-xs">
                                <i class="fas fa-clock text-yellow-500 mr-2 text-xs"></i>
                                {{ $cita->duracion }} min
                            </p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Prioridad</label>
                            <p class="text-gray-900 bg-gray-50 p-2 rounded flex items-center text-xs">
                                <i class="fas fa-exclamation-circle 
                                    @if($cita->prioridad == 'urgente') text-red-500
                                    @elseif($cita->prioridad == 'alta') text-orange-500
                                    @elseif($cita->prioridad == 'normal') text-blue-500
                                    @else text-green-500 @endif mr-2 text-xs">
                                </i>
                                <span class="capitalize text-xs">{{ $cita->prioridad }}</span>
                            </p>
                        </div>
                    </div>
                    @if($cita->es_primera_vez)
                    <div class="mt-3 bg-blue-50 border border-blue-200 rounded p-2">
                        <div class="flex items-center text-xs">
                            <i class="fas fa-star text-blue-500 mr-2 text-xs"></i>
                            <span class="text-blue-800 font-medium">Primera consulta con este médico</span>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Motivo y Síntomas - TARJETA MÁS COMPACTA -->
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-comment-medical text-green-500 mr-2 text-sm"></i>
                        Motivo y Síntomas
                    </h2>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Motivo Principal</label>
                            <div class="bg-gray-50 border border-gray-200 rounded p-3">
                                <p class="text-gray-700 whitespace-pre-line text-sm">{{ $cita->motivo_consulta }}</p>
                            </div>
                        </div>
                        @if($cita->sintomas)
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Síntomas Descritos</label>
                            <div class="bg-yellow-50 border border-yellow-200 rounded p-3">
                                <p class="text-gray-700 whitespace-pre-line text-sm">{{ $cita->sintomas }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Información Médica Previa - TARJETA MÁS COMPACTA -->
                @if($cita->alergias_notas || $cita->medicamentos_actuales || $cita->referido_por)
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-file-medical text-red-500 mr-2 text-sm"></i>
                        Información Médica Previa
                    </h2>
                    <div class="space-y-3">
                        @if($cita->alergias_notas)
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Alergias Conocidas</label>
                            <div class="bg-red-50 border border-red-200 rounded p-2">
                                <p class="text-red-700 whitespace-pre-line text-sm">{{ $cita->alergias_notas }}</p>
                            </div>
                        </div>
                        @endif

                        @if($cita->medicamentos_actuales)
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Medicamentos Actuales</label>
                            <div class="bg-purple-50 border border-purple-200 rounded p-2">
                                <p class="text-purple-700 whitespace-pre-line text-sm">{{ $cita->medicamentos_actuales }}</p>
                            </div>
                        </div>
                        @endif

                        @if($cita->referido_por)
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Referido Por</label>
                            <div class="bg-blue-50 border border-blue-200 rounded p-2">
                                <p class="text-blue-700 text-sm">{{ $cita->referido_por }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Información Médica de la Consulta - DISEÑO MÁS COMPACTO -->
                @if($cita->estado == 'completada' && ($cita->diagnostico || $cita->tratamiento || $cita->medicamentos_recetados || $cita->recomendaciones))
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-notes-medical text-green-500 mr-2 text-sm"></i>
                            Información Médica de la Consulta
                        </h2>
                        <div class="flex items-center space-x-2">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold flex items-center">
                                <i class="fas fa-check-circle mr-1 text-xs"></i>
                                Completada
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- Diagnóstico -->
                        @if($cita->diagnostico)
                        <div class="border-l-3 border-red-500 bg-red-50 rounded-r">
                            <div class="p-3">
                                <div class="flex items-center mb-2">
                                    <div class="bg-white p-1 rounded shadow-xs mr-2">
                                        <i class="fas fa-diagnoses text-red-500 text-xs"></i>
                                    </div>
                                    <h3 class="text-sm font-semibold text-gray-800">Diagnóstico</h3>
                                </div>
                                <div class="bg-white rounded p-3 border border-red-100">
                                    <p class="text-gray-700 whitespace-pre-line leading-relaxed text-sm">{{ $cita->diagnostico }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Tratamiento -->
                        @if($cita->tratamiento)
                        <div class="border-l-3 border-green-500 bg-green-50 rounded-r">
                            <div class="p-3">
                                <div class="flex items-center mb-2">
                                    <div class="bg-white p-1 rounded shadow-xs mr-2">
                                        <i class="fas fa-hand-holding-medical text-green-500 text-xs"></i>
                                    </div>
                                    <h3 class="text-sm font-semibold text-gray-800">Tratamiento Indicado</h3>
                                </div>
                                <div class="bg-white rounded p-3 border border-green-100">
                                    <p class="text-gray-700 whitespace-pre-line leading-relaxed text-sm">{{ $cita->tratamiento }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Medicamentos Recetados -->
                        @if($cita->medicamentos_recetados)
                        <div class="border-l-3 border-purple-500 bg-purple-50 rounded-r">
                            <div class="p-3">
                                <div class="flex items-center mb-2">
                                    <div class="bg-white p-1 rounded shadow-xs mr-2">
                                        <i class="fas fa-pills text-purple-500 text-xs"></i>
                                    </div>
                                    <h3 class="text-sm font-semibold text-gray-800">Medicamentos Recetados</h3>
                                </div>
                                <div class="bg-white rounded p-3 border border-purple-100">
                                    <p class="text-gray-700 whitespace-pre-line leading-relaxed text-sm">{{ $cita->medicamentos_recetados }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Recomendaciones -->
                        @if($cita->recomendaciones)
                        <div class="border-l-3 border-blue-500 bg-blue-50 rounded-r">
                            <div class="p-3">
                                <div class="flex items-center mb-2">
                                    <div class="bg-white p-1 rounded shadow-xs mr-2">
                                        <i class="fas fa-heartbeat text-blue-500 text-xs"></i>
                                    </div>
                                    <h3 class="text-sm font-semibold text-gray-800">Recomendaciones</h3>
                                </div>
                                <div class="bg-white rounded p-3 border border-blue-100">
                                    <p class="text-gray-700 whitespace-pre-line leading-relaxed text-sm">{{ $cita->recomendaciones }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Observaciones Adicionales -->
                        @if($cita->observaciones)
                        <div class="border-l-3 border-orange-500 bg-orange-50 rounded-r">
                            <div class="p-3">
                                <div class="flex items-center mb-2">
                                    <div class="bg-white p-1 rounded shadow-xs mr-2">
                                        <i class="fas fa-sticky-note text-orange-500 text-xs"></i>
                                    </div>
                                    <h3 class="text-sm font-semibold text-gray-800">Observaciones</h3>
                                </div>
                                <div class="bg-white rounded p-3 border border-orange-100">
                                    <p class="text-gray-700 whitespace-pre-line leading-relaxed text-sm">{{ $cita->observaciones }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Footer informativo compacto -->
                    <div class="mt-4 pt-3 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row justify-between items-center text-xs text-gray-600">
                            <div class="flex items-center mb-1 sm:mb-0">
                                <i class="fas fa-user-md text-blue-500 mr-1 text-xs"></i>
                                <span>Dr. {{ $cita->medico->user->name }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar-check text-green-500 mr-1 text-xs"></i>
                                <span>{{ $cita->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($cita->estado == 'completada')
                <!-- Mensaje compacto cuando no hay información médica -->
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <div class="text-center py-4">
                        <div class="bg-yellow-50 border border-yellow-200 rounded p-4 inline-block">
                            <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl mb-2"></i>
                            <h3 class="text-sm font-semibold text-gray-800 mb-1">Información Médica Pendiente</h3>
                            <p class="text-gray-600 text-xs mb-3">Cita completada sin información médica registrada.</p>
                            @if(auth()->user()->isMedico() || auth()->user()->isAdmin())
                            <a href="{{ route('citas.edit', $cita) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-medium transition duration-300 inline-flex items-center">
                                <i class="fas fa-edit mr-1 text-xs"></i>Agregar Información
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Columna 2: Información Adicional - TARJETAS MÁS COMPACTAS -->
            <div class="space-y-4">
                <!-- Información del Médico - MÁS COMPACTA -->
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-user-md text-blue-500 mr-2 text-sm"></i>
                        Información del Médico
                    </h2>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <i class="fas fa-user text-gray-400 mr-2 text-xs w-4"></i>
                            <div>
                                <p class="font-medium text-gray-900 text-sm">Dr. {{ $cita->medico->user->name }}</p>
                                <p class="text-gray-600 text-xs">{{ $cita->medico->especialidad->nombre }}</p>
                            </div>
                        </div>
                        @if($cita->medico->cedula_profesional)
                        <div class="flex items-center">
                            <i class="fas fa-id-card text-gray-400 mr-2 text-xs w-4"></i>
                            <div>
                                <p class="text-gray-600 text-xs">Cédula: {{ $cita->medico->cedula_profesional }}</p>
                            </div>
                        </div>
                        @endif
                        @if($cita->medico->telefono_consultorio)
                        <div class="flex items-center">
                            <i class="fas fa-phone text-gray-400 mr-2 text-xs w-4"></i>
                            <div>
                                <p class="text-gray-600 text-xs">{{ $cita->medico->telefono_consultorio }}</p>
                            </div>
                        </div>
                        @endif
                        @if($cita->medico->horario_atencion)
                        <div class="flex items-start">
                            <i class="fas fa-clock text-gray-400 mr-2 mt-0.5 text-xs w-4"></i>
                            <div>
                                <p class="text-gray-600 text-xs">{{ $cita->medico->horario_atencion }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Información del Paciente - MÁS COMPACTA -->
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-user-injured text-green-500 mr-2 text-sm"></i>
                        Información del Paciente
                    </h2>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <i class="fas fa-user text-gray-400 mr-2 text-xs w-4"></i>
                            <div>
                                <p class="font-medium text-gray-900 text-sm">{{ $cita->paciente->user->name }}</p>
                                <p class="text-gray-600 text-xs">{{ $cita->paciente->user->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone text-gray-400 mr-2 text-xs w-4"></i>
                            <div>
                                <p class="text-gray-600 text-xs">{{ $cita->paciente->telefono }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-birthday-cake text-gray-400 mr-2 text-xs w-4"></i>
                            <div>
                                <p class="text-gray-600 text-xs">
                                    {{ $cita->paciente->fecha_nacimiento->age }} años
                                </p>
                            </div>
                        </div>
                        @if($cita->paciente->alergias)
                        <div class="flex items-start">
                            <i class="fas fa-allergies text-red-400 mr-2 mt-0.5 text-xs w-4"></i>
                            <div>
                                <p class="text-red-600 text-xs">{{ $cita->paciente->alergias }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Signos Vitales - MÁS COMPACTO -->
                @if($cita->temperatura || $cita->peso || $cita->presion_arterial_sistolica)
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-heartbeat text-red-500 mr-2 text-sm"></i>
                        Signos Vitales
                    </h2>
                    <div class="grid grid-cols-2 gap-2">
                        @if($cita->temperatura)
                        <div class="text-center bg-blue-50 p-2 rounded">
                            <i class="fas fa-thermometer-half text-blue-500 text-sm mb-1"></i>
                            <p class="text-gray-600 text-xs">Temp</p>
                            <p class="font-bold text-blue-700 text-sm">{{ $cita->temperatura }}°C</p>
                        </div>
                        @endif

                        @if($cita->presion_arterial_sistolica && $cita->presion_arterial_diastolica)
                        <div class="text-center bg-red-50 p-2 rounded">
                            <i class="fas fa-tachometer-alt text-red-500 text-sm mb-1"></i>
                            <p class="text-gray-600 text-xs">Presión</p>
                            <p class="font-bold text-red-700 text-sm">{{ $cita->presion_arterial_sistolica }}/{{ $cita->presion_arterial_diastolica }}</p>
                        </div>
                        @endif

                        @if($cita->frecuencia_cardiaca)
                        <div class="text-center bg-green-50 p-2 rounded">
                            <i class="fas fa-heartbeat text-green-500 text-sm mb-1"></i>
                            <p class="text-gray-600 text-xs">FC</p>
                            <p class="font-bold text-green-700 text-sm">{{ $cita->frecuencia_cardiaca }}</p>
                        </div>
                        @endif

                        @if($cita->peso)
                        <div class="text-center bg-orange-50 p-2 rounded">
                            <i class="fas fa-weight text-orange-500 text-sm mb-1"></i>
                            <p class="text-gray-600 text-xs">Peso</p>
                            <p class="font-bold text-orange-700 text-sm">{{ $cita->peso }} kg</p>
                        </div>
                        @endif
                    </div>

                    @if($cita->imc)
                    <div class="mt-3 bg-gray-50 p-2 rounded">
                        <h4 class="text-xs font-semibold text-gray-800 mb-1">Índice de Masa Corporal</h4>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-bold text-gray-900 text-sm">{{ number_format($cita->imc, 1) }}</p>
                                <p class="text-gray-600 text-xs">{{ $cita->clasificacion_imc }}</p>
                            </div>
                            <div class="w-16 bg-gray-200 rounded-full h-1.5">
                                @php
                                    $porcentaje = min(100, max(0, ($cita->imc - 15) / (40 - 15) * 100));
                                    $color = 'bg-green-500';
                                    if ($cita->imc >= 25) $color = 'bg-yellow-500';
                                    if ($cita->imc >= 30) $color = 'bg-red-500';
                                @endphp
                                <div class="h-1.5 rounded-full {{ $color }}" style="width: {{ $porcentaje }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Seguimiento - MÁS COMPACTO -->
                @if($cita->seguimiento != 'ninguno' || $cita->proxima_cita || $cita->observaciones || $cita->notas)
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-calendar-check text-teal-500 mr-2 text-sm"></i>
                        Seguimiento
                    </h2>
                    <div class="space-y-2">
                        @if($cita->seguimiento != 'ninguno')
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 text-xs">Tipo:</span>
                            <span class="font-medium text-xs capitalize">{{ $cita->seguimiento }}</span>
                        </div>
                        @endif

                        @if($cita->proxima_cita)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 text-xs">Próxima cita:</span>
                            <span class="font-medium text-xs">{{ $cita->proxima_cita->format('d/m/Y') }}</span>
                        </div>
                        @endif

                        @if($cita->observaciones)
                        <div>
                            <span class="text-gray-600 text-xs">Observaciones:</span>
                            <p class="text-gray-700 text-xs mt-1 whitespace-pre-line">{{ $cita->observaciones }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Acciones - MÁS COMPACTO -->
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-cogs text-gray-500 mr-2 text-sm"></i>
                        Acciones
                    </h2>
                    <div class="space-y-2">
                        @if(auth()->user()->isMedico() || auth()->user()->isAdmin())
                        <a href="{{ route('citas.edit', $cita) }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm font-medium transition duration-300 flex items-center justify-center">
                            <i class="fas fa-edit mr-2 text-xs"></i>Editar Información
                        </a>
                        @endif
                        
                        <button onclick="window.print()" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded text-sm font-medium transition duration-300 flex items-center justify-center">
                            <i class="fas fa-print mr-2 text-xs"></i>Imprimir
                        </button>
                        
                        <a href="{{ route('citas.index') }}" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 px-3 py-2 rounded text-sm font-medium transition duration-300 flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2 text-xs"></i>Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos para impresión -->
<style>
    @media print {
        nav, footer, .bg-gray-300, .bg-blue-600, button {
            display: none !important;
        }
        body {
            background: white !important;
            font-size: 12px;
        }
        .bg-blue-50, .bg-red-50, .bg-green-50, .bg-purple-50, .bg-yellow-50, .bg-orange-50 {
            background-color: #f3f4f6 !important;
            border: 1px solid #d1d5db !important;
        }
        .shadow-sm {
            box-shadow: none !important;
        }
        .rounded-lg {
            border-radius: 0 !important;
        }
    }
</style>
@endsection