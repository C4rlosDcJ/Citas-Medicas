@extends('layouts.app')

@section('title', 'Agendar Nueva Cita')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Agendar Nueva Cita Médica</h1>

            <form action="{{ route('citas.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Especialidad -->
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

                    <!-- Médico -->
                    <div>
                        <label for="medico_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Médico
                        </label>
                        <select id="medico_id" name="medico_id" required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">Seleccione un médico</option>
                            @foreach($medicos as $medico)
                                <option value="{{ $medico->id }}" data-especialidad="{{ $medico->especialidad_id }}">
                                    Dr. {{ $medico->user->name }} - {{ $medico->especialidad->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('medico_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha y Hora -->
                    <div>
                        <label for="fecha_hora" class="block text-sm font-medium text-gray-700 mb-2">
                            Fecha y Hora
                        </label>
                        <input type="datetime-local" id="fecha_hora" name="fecha_hora" required
                               min="{{ now()->format('Y-m-d\TH:i') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @error('fecha_hora')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Motivo de Consulta -->
                    <div class="md:col-span-2">
                        <label for="motivo_consulta" class="block text-sm font-medium text-gray-700 mb-2">
                            Motivo de la Consulta
                        </label>
                        <textarea id="motivo_consulta" name="motivo_consulta" required
                                  rows="4"
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                  placeholder="Describa el motivo de su consulta...">{{ old('motivo_consulta') }}</textarea>
                        @error('motivo_consulta')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('citas.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md font-medium transition duration-300">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition duration-300">
                        <i class="fas fa-calendar-plus mr-2"></i>Agendar Cita
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
        const medicoOptions = medicoSelect.querySelectorAll('option');

        especialidadSelect.addEventListener('change', function() {
            const especialidadId = this.value;
            
            // Mostrar todos los médicos si no hay especialidad seleccionada
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
        });
    });
</script>
@endpush
@endsection