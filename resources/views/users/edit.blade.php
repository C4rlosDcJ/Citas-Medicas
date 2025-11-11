@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-user-edit text-green-500 mr-2"></i>Editar Usuario
                </h1>
                <a href="{{ route('users.show', $user) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
            </div>

            <form action="{{ route('users.update', $user) }}" method="POST" id="userForm">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Columna 1: Información Básica -->
                    <div class="space-y-6">
                        <!-- Información Personal -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-user text-blue-500 mr-2"></i>
                                Información Personal
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Nombre Completo *
                                    </label>
                                    <input type="text" id="name" name="name" required
                                           value="{{ old('name', $user->name) }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email *
                                    </label>
                                    <input type="email" id="email" name="email" required
                                           value="{{ old('email', $user->email) }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="cedula" class="block text-sm font-medium text-gray-700 mb-1">
                                        CURP
                                    </label>
                                    <input type="text" id="cedula" name="cedula"
                                           value="{{ old('cedula', $user->cedula) }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @error('cedula')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="border-t pt-4">
                                    <p class="text-sm text-gray-600 mb-2">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Dejar en blanco para no cambiar la contraseña
                                    </p>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                                Nueva Contraseña
                                            </label>
                                            <input type="password" id="password" name="password"
                                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            @error('password')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                                Confirmar Contraseña
                                            </label>
                                            <input type="password" id="password_confirmation" name="password_confirmation"
                                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-address-book text-green-500 mr-2"></i>
                                Información de Contacto
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">
                                        Teléfono *
                                    </label>
                                    <input type="text" id="telefono" name="telefono" required
                                           value="{{ old('telefono', $user->telefono) }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @error('telefono')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">
                                        Dirección
                                    </label>
                                    <textarea id="direccion" name="direccion" rows="3"
                                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                              placeholder="Dirección completa...">{{ old('direccion', $user->direccion) }}</textarea>
                                    @error('direccion')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna 2: Información Específica -->
                    <div class="space-y-6">
                        <!-- Rol y Datos Demográficos -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-user-tag text-purple-500 mr-2"></i>
                                Rol y Datos Demográficos
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        Rol del Usuario *
                                    </label>
                                    <select id="role_id" name="role_id" required
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <option value="">Seleccione un rol</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                                {{ $role->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-1">
                                            Fecha de Nacimiento *
                                        </label>
                                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required
                                               value="{{ old('fecha_nacimiento', $user->fecha_nacimiento ? $user->fecha_nacimiento->format('Y-m-d') : '') }}"
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        @error('fecha_nacimiento')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="genero" class="block text-sm font-medium text-gray-700 mb-1">
                                            Género *
                                        </label>
                                        <select id="genero" name="genero" required
                                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <option value="">Seleccione</option>
                                            <option value="masculino" {{ old('genero', $user->genero) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                            <option value="femenino" {{ old('genero', $user->genero) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                            <option value="otro" {{ old('genero', $user->genero) == 'otro' ? 'selected' : '' }}>Otro</option>
                                        </select>
                                        @error('genero')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información del Médico (si aplica) -->
                        @if($user->isMedico() && $user->medico)
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-user-md text-blue-500 mr-2"></i>
                                Información Médica
                            </h3>
                            <p class="text-sm text-gray-600 mb-3">
                                <i class="fas fa-info-circle mr-1"></i>
                                La información específica del médico se gestiona por separado
                            </p>
                            <div class="bg-blue-50 border border-blue-200 rounded p-3">
                                <p class="text-sm text-blue-800">
                                    <strong>Especialidad:</strong> {{ $user->medico->especialidad->nombre ?? 'No especificada' }}
                                </p>
                                <p class="text-sm text-blue-800 mt-1">
                                    <strong>Cédula Profesional:</strong> {{ $user->medico->cedula_profesional }}
                                </p>
                            </div>
                        </div>
                        @endif

                        <!-- Información del Paciente (si aplica) -->
                        @if($user->isPaciente() && $user->paciente)
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-file-medical text-green-500 mr-2"></i>
                                Información Médica del Paciente
                            </h3>
                            <p class="text-sm text-gray-600 mb-3">
                                <i class="fas fa-info-circle mr-1"></i>
                                La información específica del paciente se gestiona por separado
                            </p>
                            <div class="bg-green-50 border border-green-200 rounded p-3">
                                <p class="text-sm text-green-800">
                                    <strong>Alergias:</strong> {{ $user->paciente->alergias ?? 'Ninguna registrada' }}
                                </p>
                            </div>
                        </div>
                        @endif

                        <!-- Notas Adicionales -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-sticky-note text-yellow-500 mr-2"></i>
                                Notas Adicionales
                            </h3>
                            
                            <div>
                                <label for="notas" class="block text-sm font-medium text-gray-700 mb-1">
                                    Notas
                                </label>
                                <textarea id="notas" name="notas" rows="3"
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                          placeholder="Notas adicionales sobre el usuario...">{{ old('notas', $user->notas) }}</textarea>
                                @error('notas')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('users.show', $user) }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-md font-medium transition duration-300">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </a>
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-md font-medium transition duration-300 flex items-center">
                        <i class="fas fa-save mr-2"></i>Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('userForm');
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        
        // Validación de contraseña
        function validatePassword() {
            if (password.value && password.value !== passwordConfirmation.value) {
                passwordConfirmation.setCustomValidity('Las contraseñas no coinciden');
            } else {
                passwordConfirmation.setCustomValidity('');
            }
        }

        password.addEventListener('input', validatePassword);
        passwordConfirmation.addEventListener('input', validatePassword);

        // // Validación de fecha de nacimiento
        // const fechaNacimiento = document.getElementById('fecha_nacimiento');
        // fechaNacimiento.addEventListener('change', function() {
        //     const selectedDate = new Date(this.value);
        //     const today = new Date();
        //     const minDate = new Date();
        //     minDate.setFullYear(today.getFullYear() - 100);
            
        //     if (selectedDate > today) {
        //         alert('La fecha de nacimiento no puede ser futura.');
        //         this.value = '{{ $user->fecha_nacimiento ? $user->fecha_nacimiento->format("Y-m-d") : "" }}';
        //     } else if (selectedDate < minDate) {
        //         alert('La fecha de nacimiento no puede ser hace más de 100 años.');
        //         this.value = '{{ $user->fecha_nacimiento ? $user->fecha_nacimiento->format("Y-m-d") : "" }}';
        //     }
        // });

        // Prevenir envío duplicado
        form.addEventListener('submit', function() {
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Actualizando...';
        });
    });
</script>
@endpush
@endsection