@extends('layouts.app')

@section('title', 'Editar Información Médica de la Cita')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Consulta Médica</h1>
                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-user-injured text-blue-500 mr-2"></i>
                            <span class="font-semibold">{{ $cita->paciente->user->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar text-green-500 mr-2"></i>
                            <span>{{ $cita->fecha_hora->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-semibold mr-2">Estado:</span>
                            <span class="px-3 py-1 text-xs font-bold rounded-full 
                                @if($cita->estado == 'pendiente') bg-yellow-100 text-yellow-800 border border-yellow-300
                                @elseif($cita->estado == 'confirmada') bg-blue-100 text-blue-800 border border-blue-300
                                @elseif($cita->estado == 'completada') bg-green-100 text-green-800 border border-green-300
                                @else bg-red-100 text-red-800 border border-red-300 @endif">
                                {{ ucfirst($cita->estado) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('citas.show', $cita) }}" 
                       class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg font-medium border border-gray-300 transition-all duration-200">
                        <i class="fas fa-eye mr-2"></i>Ver Cita
                    </a>
                    <a href="{{ route('citas.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>

        <!-- Alertas -->
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
                <div class="flex">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3 mt-1"></i>
                    <div>
                        <h4 class="font-bold text-red-800 mb-1">Errores de validación:</h4>
                        <ul class="list-disc list-inside text-red-700 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mb-6">
                <div class="flex">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3 mt-1"></i>
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
                <div class="flex">
                    <i class="fas fa-times-circle text-red-500 text-xl mr-3 mt-1"></i>
                    <span class="text-red-800 font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <form action="{{ route('citas.update-medical', $cita) }}" method="POST" id="medicalForm">
            @csrf
            @method('PATCH')
            
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
                <!-- Sidebar - Signos Vitales -->
                <div class="xl:col-span-1 space-y-6">
                    <!-- Tarjeta Signos Vitales -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-red-100 p-2 rounded-lg">
                                <i class="fas fa-heartbeat text-red-500 text-lg"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 ml-3">Signos Vitales</h3>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- Temperatura -->
                            <div>
                                <label for="temperatura" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Temperatura (°C)
                                </label>
                                <input type="number" id="temperatura" name="temperatura" step="0.1" min="35" max="42"
                                       value="{{ old('temperatura', $cita->temperatura) }}"
                                       class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                            </div>

                            <!-- Presión Arterial -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Presión Arterial
                                </label>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <input type="number" id="presion_arterial_sistolica" name="presion_arterial_sistolica"
                                               placeholder="Sistólica"
                                               value="{{ old('presion_arterial_sistolica', $cita->presion_arterial_sistolica) }}"
                                               class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                    </div>
                                    <div>
                                        <input type="number" id="presion_arterial_diastolica" name="presion_arterial_diastolica"
                                               placeholder="Diastólica"
                                               value="{{ old('presion_arterial_diastolica', $cita->presion_arterial_diastolica) }}"
                                               class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                    </div>
                                </div>
                            </div>

                            <!-- Frecuencias -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="frecuencia_cardiaca" class="block text-sm font-semibold text-gray-700 mb-2">
                                        FC (lpm)
                                    </label>
                                    <input type="number" id="frecuencia_cardiaca" name="frecuencia_cardiaca"
                                           value="{{ old('frecuencia_cardiaca', $cita->frecuencia_cardiaca) }}"
                                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                </div>
                                <div>
                                    <label for="frecuencia_respiratoria" class="block text-sm font-semibold text-gray-700 mb-2">
                                        FR (rpm)
                                    </label>
                                    <input type="number" id="frecuencia_respiratoria" name="frecuencia_respiratoria"
                                           value="{{ old('frecuencia_respiratoria', $cita->frecuencia_respiratoria) }}"
                                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                </div>
                            </div>

                            <!-- Peso y Altura -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="peso" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Peso (kg)
                                    </label>
                                    <input type="number" id="peso" name="peso" step="0.1"
                                           value="{{ old('peso', $cita->peso) }}"
                                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                </div>
                                <div>
                                    <label for="altura" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Altura (m)
                                    </label>
                                    <input type="number" id="altura" name="altura" step="0.01"
                                           value="{{ old('altura', $cita->altura) }}"
                                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                </div>
                            </div>

                            <!-- IMC Calculado -->
                            <div id="imc-calculado" class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-200 mt-4">
                                <p class="text-sm font-bold text-gray-800 mb-1">IMC Calculado: <span id="imc-valor" class="text-blue-600">--</span></p>
                                <p class="text-sm text-gray-600">Clasificación: <span id="imc-clasificacion" class="font-semibold">--</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta Seguimiento -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-teal-100 p-2 rounded-lg">
                                <i class="fas fa-calendar-check text-teal-500 text-lg"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 ml-3">Seguimiento</h3>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="seguimiento" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tipo de Seguimiento
                                </label>
                                <select id="seguimiento" name="seguimiento"
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                    <option value="ninguno" {{ old('seguimiento', $cita->seguimiento) == 'ninguno' ? 'selected' : '' }}>Ninguno</option>
                                    <option value="control" {{ old('seguimiento', $cita->seguimiento) == 'control' ? 'selected' : '' }}>Control</option>
                                    <option value="especialista" {{ old('seguimiento', $cita->seguimiento) == 'especialista' ? 'selected' : '' }}>Especialista</option>
                                    <option value="urgencias" {{ old('seguimiento', $cita->seguimiento) == 'urgencias' ? 'selected' : '' }}>Urgencias</option>
                                </select>
                            </div>

                            <div>
                                <label for="proxima_cita" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Próxima Cita
                                </label>
                                <input type="date" id="proxima_cita" name="proxima_cita"
                                       value="{{ old('proxima_cita', $cita->proxima_cita ? $cita->proxima_cita->format('Y-m-d') : '') }}"
                                       class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenido Principal -->
                <div class="xl:col-span-3 space-y-6">
                    <!-- Diagnóstico -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-red-100 p-2 rounded-lg">
                                <i class="fas fa-diagnoses text-red-500 text-lg"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 ml-3">Diagnóstico</h3>
                        </div>
                        <textarea id="diagnostico" name="diagnostico" rows="4"
                                  class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                  placeholder="Describa el diagnóstico del paciente...">{{ old('diagnostico', $cita->diagnostico) }}</textarea>
                    </div>

                    <!-- Tratamiento -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 p-2 rounded-lg">
                                <i class="fas fa-hand-holding-medical text-green-500 text-lg"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 ml-3">Tratamiento Indicado</h3>
                        </div>
                        <textarea id="tratamiento" name="tratamiento" rows="4"
                                  class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                  placeholder="Describa el tratamiento indicado...">{{ old('tratamiento', $cita->tratamiento) }}</textarea>
                    </div>

                    <!-- Medicamentos -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-100 p-2 rounded-lg">
                                <i class="fas fa-pills text-purple-500 text-lg"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 ml-3">Medicamentos Recetados</h3>
                        </div>
                        <textarea id="medicamentos_recetados" name="medicamentos_recetados" rows="3"
                                  class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                  placeholder="Lista de medicamentos recetados...">{{ old('medicamentos_recetados', $cita->medicamentos_recetados) }}</textarea>
                    </div>

                    <!-- Recomendaciones y Observaciones -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Recomendaciones -->
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-pink-100 p-2 rounded-lg">
                                    <i class="fas fa-heartbeat text-pink-500 text-lg"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800 ml-3">Recomendaciones</h3>
                            </div>
                            <textarea id="recomendaciones" name="recomendaciones" rows="4"
                                      class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                      placeholder="Recomendaciones para el paciente...">{{ old('recomendaciones', $cita->recomendaciones) }}</textarea>
                        </div>

                        <!-- Observaciones -->
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-orange-100 p-2 rounded-lg">
                                    <i class="fas fa-sticky-note text-orange-500 text-lg"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800 ml-3">Observaciones</h3>
                            </div>
                            <textarea id="observaciones" name="observaciones" rows="4"
                                      class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                      placeholder="Observaciones adicionales...">{{ old('observaciones', $cita->observaciones) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="mt-8 bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        Todos los campos son opcionales pero recomendados.
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('citas.index') }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </a>
                        
                        <button type="submit" name="action" value="guardar"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200">
                            <i class="fas fa-save mr-2"></i>Guardar Información
                        </button>
                        
                        @if($cita->estado != 'completada')
                        <button type="submit" name="action" value="completar" id="completarBtn"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200">
                            <i class="fas fa-check-double mr-2"></i>Guardar y Completar Cita
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calcular IMC en tiempo real
    const pesoInput = document.getElementById('peso');
    const alturaInput = document.getElementById('altura');
    const imcValor = document.getElementById('imc-valor');
    const imcClasificacion = document.getElementById('imc-clasificacion');

    function calcularIMC() {
        const peso = parseFloat(pesoInput?.value);
        const altura = parseFloat(alturaInput?.value);
        
        if (peso && altura && altura > 0 && imcValor && imcClasificacion) {
            const imc = peso / (altura * altura);
            const imcRedondeado = imc.toFixed(2);
            
            imcValor.textContent = imcRedondeado;
            
            let clasificacion = '';
            let color = '';
            
            if (imc < 18.5) {
                clasificacion = 'Bajo peso';
                color = 'text-yellow-600';
            } else if (imc < 25) {
                clasificacion = 'Normal';
                color = 'text-green-600';
            } else if (imc < 30) {
                clasificacion = 'Sobrepeso';
                color = 'text-orange-600';
            } else {
                clasificacion = 'Obesidad';
                color = 'text-red-600';
            }
            
            imcClasificacion.textContent = clasificacion;
            imcClasificacion.className = 'font-semibold ' + color;
        }
    }

    if (pesoInput && alturaInput) {
        pesoInput.addEventListener('input', calcularIMC);
        alturaInput.addEventListener('input', calcularIMC);
        // Calcular IMC inicial si hay valores
        if (pesoInput.value && alturaInput.value) {
            calcularIMC();
        }
    }

    // Confirmación para completar cita
    const completarBtn = document.getElementById('completarBtn');
    if (completarBtn) {
        completarBtn.addEventListener('click', function(e) {
            if (!confirm('¿Estás seguro de que deseas COMPLETAR esta cita?\n\nLa cita cambiará a estado "COMPLETADA".')) {
                e.preventDefault();
            }
        });
    }

    // Validación simple
    const form = document.getElementById('medicalForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const paSistolica = document.getElementById('presion_arterial_sistolica');
            const paDiastolica = document.getElementById('presion_arterial_diastolica');
            
            if (paSistolica && paDiastolica) {
                if ((paSistolica.value && !paDiastolica.value) || (!paSistolica.value && paDiastolica.value)) {
                    e.preventDefault();
                    alert('Por favor, complete ambos valores de presión arterial o deje ambos vacíos.');
                    return false;
                }
            }
        });
    }
});
</script>
@endpush