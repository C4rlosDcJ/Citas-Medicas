@extends('layouts.app')

@section('title', 'Agendar Nueva Cita')

@section('content')
<div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    @if(auth()->user()->isPaciente())
                        <i class="fas fa-calendar-plus text-blue-500 mr-2"></i>Agendar Nueva Cita
                    @else
                        <i class="fas fa-calendar-plus text-green-500 mr-2"></i>Crear Nueva Cita
                    @endif
                </h1>
                <a href="{{ route('citas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md font-medium transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
            </div>

            @if(auth()->user()->isMedico() || auth()->user()->isAdmin())
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 text-xl mr-3"></i>
                    <div>
                        <p class="text-blue-800 font-medium">Creando cita para paciente</p>
                        <p class="text-blue-600 text-sm">Estás creando una cita en nombre de un paciente.</p>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('citas.store') }}" method="POST" id="citaForm">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Columna 1: Información Básica -->
                    <div class="space-y-6">
                        <!-- Selección de Paciente (solo para médicos y admin) -->
                        @if(auth()->user()->isMedico() || auth()->user()->isAdmin())
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-user-injured text-green-500 mr-2"></i>
                                Información del Paciente
                            </h3>
                            <div>
                                <label for="paciente_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Seleccionar Paciente *
                                </label>
                                <select id="paciente_id" name="paciente_id" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="">Seleccione un paciente</option>
                                    @foreach($pacientes as $paciente)
                                        <option value="{{ $paciente->id }}" data-alergias="{{ $paciente->alergias }}" data-antecedentes="{{ $paciente->antecedentes_medicos }}">
                                            {{ $paciente->user->name }} - {{ $paciente->telefono }} - {{ $paciente->fecha_nacimiento->age }} años
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Información del paciente seleccionado -->
                            <div id="info-paciente" class="mt-4 hidden">
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <h4 class="font-medium text-gray-700 mb-2">Información del Paciente:</h4>
                                    <div class="grid grid-cols-2 gap-2 text-sm">
                                        <div><span class="font-medium">Edad:</span> <span id="info-edad"></span></div>
                                        <div><span class="font-medium">Teléfono:</span> <span id="info-telefono"></span></div>
                                        <div class="col-span-2"><span class="font-medium">Alergias:</span> <span id="info-alergias" class="text-red-600"></span></div>
                                        <div class="col-span-2"><span class="font-medium">Antecedentes:</span> <span id="info-antecedentes"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Tipo de Cita y Prioridad -->
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-cog text-purple-500 mr-2"></i>
                                Configuración de la Cita
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="tipo_cita" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tipo de Cita *
                                    </label>
                                    <select id="tipo_cita" name="tipo_cita" required
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <option value="consulta">Consulta General</option>
                                        <option value="control">Control</option>
                                        <option value="emergencia">Emergencia</option>
                                        <option value="seguimiento">Seguimiento</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="duracion" class="block text-sm font-medium text-gray-700 mb-2">
                                        Duración Estimada *
                                    </label>
                                    <select id="duracion" name="duracion" required
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <option value="30">30 minutos</option>
                                        <option value="45">45 minutos</option>
                                        <option value="60">1 hora</option>
                                        <option value="90">1 hora 30 minutos</option>
                                        <option value="120">2 horas</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="prioridad" class="block text-sm font-medium text-gray-700 mb-2">
                                    Prioridad
                                </label>
                                <select id="prioridad" name="prioridad"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="baja">Baja</option>
                                    <option value="normal" selected>Normal</option>
                                    <option value="alta">Alta</option>
                                    <option value="urgente">Urgente</option>
                                </select>
                            </div>
                        </div>

                        <!-- Información Médica Adicional -->
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-file-medical text-red-500 mr-2"></i>
                                Información Médica
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="es_primera_vez" class="flex items-center">
                                        <input type="checkbox" id="es_primera_vez" name="es_primera_vez" value="1" checked
                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 mr-2">
                                        <span class="text-sm font-medium text-gray-700">Es primera vez que visita</span>
                                    </label>
                                </div>

                                <div>
                                    <label for="referido_por" class="block text-sm font-medium text-gray-700 mb-1">
                                        Referido por
                                    </label>
                                    <input type="text" id="referido_por" name="referido_por"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           placeholder="Especialista que refirió al paciente (opcional)">
                                </div>

                                <div>
                                    <label for="alergias_notas" class="block text-sm font-medium text-gray-700 mb-1">
                                        Alergias Conocidas
                                    </label>
                                    <textarea id="alergias_notas" name="alergias_notas" rows="2"
                                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                              placeholder="Lista de alergias conocidas..."></textarea>
                                </div>

                                <div>
                                    <label for="medicamentos_actuales" class="block text-sm font-medium text-gray-700 mb-1">
                                        Medicamentos Actuales
                                    </label>
                                    <textarea id="medicamentos_actuales" name="medicamentos_actuales" rows="2"
                                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                              placeholder="Medicamentos que está tomando actualmente..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna 2: Selección Médico y Fecha -->
                    <div class="space-y-6">
                        <!-- Selección de Médico y Especialidad -->
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-user-md text-blue-500 mr-2"></i>
                                Selección de Médico
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="especialidad_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Especialidad Médica
                                    </label>
                                    <select id="especialidad_id" name="especialidad_id"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <option value="">Seleccione una especialidad</option>
                                        @foreach($especialidades as $especialidad)
                                            <option value="{{ $especialidad->id }}">{{ $especialidad->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="medico_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Médico *
                                    </label>
                                    <select id="medico_id" name="medico_id" required
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <option value="">Seleccione un médico</option>
                                        @foreach($medicos as $medico)
                                            <option value="{{ $medico->id }}" 
                                                    data-especialidad="{{ $medico->especialidad_id }}"
                                                    data-horario="{{ $medico->horario_atencion }}"
                                                    data-consultorio="{{ $medico->telefono_consultorio }}"
                                                    @if($medicoId && $medico->id == $medicoId) selected @endif>
                                                Dr. {{ $medico->user->name }} - {{ $medico->especialidad->nombre }}
                                                @if($medico->cedula_profesional)
                                                    (Cédula: {{ $medico->cedula_profesional }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('medico_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Información del médico seleccionado -->
                                <div id="info-medico" class="hidden">
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                        <h4 class="font-medium text-blue-800 mb-2">Información del Médico:</h4>
                                        <div class="text-sm text-blue-700 space-y-1">
                                            <div><i class="fas fa-clock mr-2"></i><span id="info-horario"></span></div>
                                            <div><i class="fas fa-phone mr-2"></i><span id="info-consultorio"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fecha y Hora -->
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-calendar-alt text-green-500 mr-2"></i>
                                Fecha y Hora
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="fecha_hora" class="block text-sm font-medium text-gray-700 mb-2">
                                        Fecha y Hora *
                                    </label>
                                    <input type="datetime-local" id="fecha_hora" name="fecha_hora" required
                                           min="{{ now()->format('Y-m-d\TH:i') }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @error('fecha_hora')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Horarios disponibles sugeridos -->
                                <div id="horarios-sugeridos" class="hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Horarios Disponibles Sugeridos
                                    </label>
                                    <div class="grid grid-cols-2 gap-2" id="lista-horarios">
                                        <!-- Los horarios se generarán con JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Motivo de Consulta y Síntomas -->
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-comment-medical text-orange-500 mr-2"></i>
                                Motivo de la Consulta
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="motivo_consulta" class="block text-sm font-medium text-gray-700 mb-2">
                                        Motivo Principal de la Consulta *
                                    </label>
                                    <textarea id="motivo_consulta" name="motivo_consulta" required
                                              rows="3"
                                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                              placeholder="Describa el motivo principal de la consulta...">{{ old('motivo_consulta') }}</textarea>
                                    @error('motivo_consulta')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="sintomas" class="block text-sm font-medium text-gray-700 mb-2">
                                        Síntomas Principales
                                    </label>
                                    <textarea id="sintomas" name="sintomas"
                                              rows="3"
                                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                              placeholder="Describa los síntomas que está experimentando...">{{ old('sintomas') }}</textarea>
                                </div>

                                <div>
                                    <label for="notas" class="block text-sm font-medium text-gray-700 mb-2">
                                        Notas Adicionales
                                    </label>
                                    <textarea id="notas" name="notas"
                                              rows="2"
                                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                              placeholder="Otra información relevante...">{{ old('notas') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resumen de la Cita -->
                <div class="mt-8 bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-clipboard-list text-purple-500 mr-2"></i>
                        Resumen de la Cita
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm" id="resumen-cita">
                        <div class="text-center">
                            <p class="font-medium text-gray-600">Tipo de Cita</p>
                            <p id="resumen-tipo" class="text-gray-800">-</p>
                        </div>
                        <div class="text-center">
                            <p class="font-medium text-gray-600">Duración</p>
                            <p id="resumen-duracion" class="text-gray-800">-</p>
                        </div>
                        <div class="text-center">
                            <p class="font-medium text-gray-600">Prioridad</p>
                            <p id="resumen-prioridad" class="text-gray-800">-</p>
                        </div>
                        <div class="text-center">
                            <p class="font-medium text-gray-600">Médico</p>
                            <p id="resumen-medico" class="text-gray-800">-</p>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('citas.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-md font-medium transition duration-300">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-md font-medium transition duration-300 flex items-center">
                        <i class="fas fa-calendar-check mr-2"></i>
                        @if(auth()->user()->isPaciente())
                            Agendar Cita
                        @else
                            Crear Cita
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const especialidadSelect = document.getElementById('especialidad_id');
        const medicoSelect = document.getElementById('medico_id');
        const pacienteSelect = document.getElementById('paciente_id');
        const tipoCitaSelect = document.getElementById('tipo_cita');
        const duracionSelect = document.getElementById('duracion');
        const prioridadSelect = document.getElementById('prioridad');
        const fechaHoraInput = document.getElementById('fecha_hora');
        
        const medicoOptions = medicoSelect.querySelectorAll('option');
        const infoMedico = document.getElementById('info-medico');
        const infoPaciente = document.getElementById('info-paciente');
        const horariosSugeridos = document.getElementById('horarios-sugeridos');

        // Filtrar médicos por especialidad
        especialidadSelect.addEventListener('change', function() {
            const especialidadId = this.value;
            
            medicoOptions.forEach(option => {
                if (option.value === '') {
                    option.style.display = 'block';
                    return;
                }
                
                if (!especialidadId || option.getAttribute('data-especialidad') === especialidadId) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });

            // Resetear la selección del médico
            medicoSelect.value = '';
            infoMedico.classList.add('hidden');
        });

        // Mostrar información del médico seleccionado
        medicoSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (selectedOption.value && selectedOption.getAttribute('data-horario')) {
                document.getElementById('info-horario').textContent = selectedOption.getAttribute('data-horario') || 'No especificado';
                document.getElementById('info-consultorio').textContent = selectedOption.getAttribute('data-consultorio') || 'No especificado';
                infoMedico.classList.remove('hidden');
                
                // Generar horarios sugeridos
                generarHorariosSugeridos();
            } else {
                infoMedico.classList.add('hidden');
                horariosSugeridos.classList.add('hidden');
            }
            
            actualizarResumen();
        });

        // Mostrar información del paciente seleccionado
        if (pacienteSelect) {
            pacienteSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                
                if (selectedOption.value) {
                    const texto = selectedOption.textContent;
                    const partes = texto.split(' - ');
                    
                    // Extraer información básica
                    document.getElementById('info-telefono').textContent = partes[1] || 'No disponible';
                    document.getElementById('info-edad').textContent = partes[2] || 'No disponible';
                    
                    // Información médica
                    document.getElementById('info-alergias').textContent = 
                        selectedOption.getAttribute('data-alergias') || 'Ninguna registrada';
                    document.getElementById('info-antecedentes').textContent = 
                        selectedOption.getAttribute('data-antecedentes') || 'Ninguno registrado';
                    
                    infoPaciente.classList.remove('hidden');
                } else {
                    infoPaciente.classList.add('hidden');
                }
            });
        }

        // Actualizar resumen en tiempo real
        function actualizarResumen() {
            document.getElementById('resumen-tipo').textContent = 
                tipoCitaSelect.options[tipoCitaSelect.selectedIndex].text;
            document.getElementById('resumen-duracion').textContent = 
                duracionSelect.options[duracionSelect.selectedIndex].text;
            document.getElementById('resumen-prioridad').textContent = 
                prioridadSelect.options[prioridadSelect.selectedIndex].text;
            document.getElementById('resumen-medico').textContent = 
                medicoSelect.options[medicoSelect.selectedIndex].text.split(' - ')[0] || '-';
        }

        // Generar horarios sugeridos
        function generarHorariosSugeridos() {
            if (!fechaHoraInput.value) return;
            
            const fechaSeleccionada = new Date(fechaHoraInput.value);
            const hoy = new Date();
            
            // Solo generar horarios para fechas futuras
            if (fechaSeleccionada <= hoy) return;
            
            const horarios = [];
            const horaInicio = 8; // 8:00 AM
            const horaFin = 17;   // 5:00 PM
            
            for (let hora = horaInicio; hora < horaFin; hora++) {
                for (let minuto = 0; minuto < 60; minuto += 30) {
                    const horario = new Date(fechaSeleccionada);
                    horario.setHours(hora, minuto, 0, 0);
                    
                    // Solo horarios futuros
                    if (horario > hoy) {
                        horarios.push(horario);
                    }
                }
            }
            
            // Mostrar primeros 4 horarios
            const listaHorarios = document.getElementById('lista-horarios');
            listaHorarios.innerHTML = '';
            
            horarios.slice(0, 4).forEach(horario => {
                const boton = document.createElement('button');
                boton.type = 'button';
                boton.className = 'bg-white border border-gray-300 rounded-md px-3 py-2 text-sm hover:bg-blue-50 hover:border-blue-300 transition duration-300';
                boton.textContent = horario.toLocaleTimeString('es-ES', { 
                    hour: '2-digit', 
                    minute: '2-digit',
                    hour12: false 
                });
                
                boton.addEventListener('click', function() {
                    const fechaISO = horario.toISOString().slice(0, 16);
                    fechaHoraInput.value = fechaISO;
                });
                
                listaHorarios.appendChild(boton);
            });
            
            horariosSugeridos.classList.remove('hidden');
        }

        // Event listeners para actualizar resumen
        tipoCitaSelect.addEventListener('change', actualizarResumen);
        duracionSelect.addEventListener('change', actualizarResumen);
        prioridadSelect.addEventListener('change', actualizarResumen);
        fechaHoraInput.addEventListener('change', generarHorariosSugeridos);

        // Inicializar resumen
        actualizarResumen();

        // Validación de fecha y hora
        fechaHoraInput.addEventListener('change', function() {
            const fechaSeleccionada = new Date(this.value);
            const ahora = new Date();
            
            if (fechaSeleccionada <= ahora) {
                alert('Por favor, seleccione una fecha y hora futura.');
                this.value = '';
            }
        });

        // Auto-completar alergias si es paciente
        @if(auth()->user()->isPaciente() && auth()->user()->paciente)
            document.getElementById('alergias_notas').value = '{{ auth()->user()->paciente->alergias }}';
        @endif
    });
</script>
@endpush
@endsection