@extends('layouts.app')

@section('title', 'Crear Nuevo Usuario')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-user-plus text-purple-500 mr-2"></i>Crear Nuevo Usuario
                </h1>
                <a href="{{ route('users.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
            </div>

            <form action="{{ route('users.store') }}" method="POST" id="userForm">
                @csrf

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
                                           value="{{ old('name') }}"
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
                                           value="{{ old('email') }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                            Contraseña *
                                        </label>
                                        <input type="password" id="password" name="password" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        @error('password')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                            Confirmar Contraseña *
                                        </label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" required
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </div>
                                </div>

                                <div>
                                    <label for="cedula" class="block text-sm font-medium text-gray-700 mb-1">
                                        CURP
                                    </label>
                                    <input type="text" id="cedula" name="cedula"
                                           value="{{ old('cedula') }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @error('cedula')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
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
                                           value="{{ old('telefono') }}"
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
                                              placeholder="Dirección completa...">{{ old('direccion') }}</textarea>
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
                                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
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
                                               value="{{ old('fecha_nacimiento') }}"
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
                                            <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                            <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                            <option value="otro" {{ old('genero') == 'otro' ? 'selected' : '' }}>Otro</option>
                                        </select>
                                        @error('genero')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información Específica por Rol -->
                        <div id="medico-info" class="bg-white border border-gray-200 rounded-lg p-6 hidden">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-user-md text-blue-500 mr-2"></i>
                                Información Médica
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="especialidad_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        Especialidad *
                                    </label>
                                    <select id="especialidad_id" name="especialidad_id"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <option value="">Seleccione una especialidad</option>
                                        @foreach($especialidades as $especialidad)
                                            <option value="{{ $especialidad->id }}" {{ old('especialidad_id') == $especialidad->id ? 'selected' : '' }}>
                                                {{ $especialidad->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('especialidad_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="cedula_profesional" class="block text-sm font-medium text-gray-700 mb-1">
                                        Cédula Profesional *
                                    </label>
                                    <input type="text" id="cedula_profesional" name="cedula_profesional"
                                           value="{{ old('cedula_profesional') }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @error('cedula_profesional')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="telefono_consultorio" class="block text-sm font-medium text-gray-700 mb-1">
                                        Teléfono del Consultorio *
                                    </label>
                                    <input type="text" id="telefono_consultorio" name="telefono_consultorio"
                                           value="{{ old('telefono_consultorio') }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @error('telefono_consultorio')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="horario_atencion" class="block text-sm font-medium text-gray-700 mb-1">
                                        Horario de Atención *
                                    </label>
                                    <input type="text" id="horario_atencion" name="horario_atencion"
                                           value="{{ old('horario_atencion') }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           placeholder="Ej: Lunes a Viernes 8:00 - 16:00">
                                    @error('horario_atencion')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div id="paciente-info" class="bg-white border border-gray-200 rounded-lg p-6 hidden">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-file-medical text-green-500 mr-2"></i>
                                Información Médica del Paciente
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="alergias" class="block text-sm font-medium text-gray-700 mb-1">
                                        Alergias Conocidas
                                    </label>
                                    <textarea id="alergias" name="alergias" rows="2"
                                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                              placeholder="Lista de alergias conocidas...">{{ old('alergias') }}</textarea>
                                    @error('alergias')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="antecedentes_medicos" class="block text-sm font-medium text-gray-700 mb-1">
                                        Antecedentes Médicos
                                    </label>
                                    <textarea id="antecedentes_medicos" name="antecedentes_medicos" rows="3"
                                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                              placeholder="Antecedentes médicos relevantes...">{{ old('antecedentes_medicos') }}</textarea>
                                    @error('antecedentes_medicos')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

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
                                          placeholder="Notas adicionales sobre el usuario...">{{ old('notas') }}</textarea>
                                @error('notas')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('users.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-md font-medium transition duration-300">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </a>
                    <button type="submit" 
                            class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-md font-medium transition duration-300 flex items-center">
                        <i class="fas fa-user-plus mr-2"></i>Crear Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role_id');
        const medicoInfo = document.getElementById('medico-info');
        const pacienteInfo = document.getElementById('paciente-info');
        const form = document.getElementById('userForm');

        // Mostrar/ocultar información específica por rol
        function toggleRoleSpecificInfo() {
            const roleId = roleSelect.value;
            
            // Ocultar todo primero
            medicoInfo.classList.add('hidden');
            pacienteInfo.classList.add('hidden');
            
            // Mostrar según el rol seleccionado
            if (roleId == 2) { // Médico
                medicoInfo.classList.remove('hidden');
                // Hacer campos requeridos
                document.getElementById('especialidad_id').required = true;
                document.getElementById('cedula_profesional').required = true;
                document.getElementById('telefono_consultorio').required = true;
                document.getElementById('horario_atencion').required = true;
            } else if (roleId == 3) { // Paciente
                pacienteInfo.classList.remove('hidden');
                // Quitar requeridos de médico
                document.getElementById('especialidad_id').required = false;
                document.getElementById('cedula_profesional').required = false;
                document.getElementById('telefono_consultorio').required = false;
                document.getElementById('horario_atencion').required = false;
            } else {
                // Quitar requeridos para otros roles
                document.getElementById('especialidad_id').required = false;
                document.getElementById('cedula_profesional').required = false;
                document.getElementById('telefono_consultorio').required = false;
                document.getElementById('horario_atencion').required = false;
            }
        }

        // Event listener para cambios en el rol
        roleSelect.addEventListener('change', toggleRoleSpecificInfo);

        // Ejecutar al cargar la página
        toggleRoleSpecificInfo();

        // // Validación de fecha de nacimiento
        // const fechaNacimiento = document.getElementById('fecha_nacimiento');
        // fechaNacimiento.addEventListener('change', function() {
        //     const selectedDate = new Date(this.value);
        //     const today = new Date();
        //     const minDate = new Date();
        //     minDate.setFullYear(today.getFullYear() - 100); // 100 años máximo
            
        //     if (selectedDate > today) {
        //         alert('La fecha de nacimiento no puede ser futura.');
        //         this.value = '';
        //     } else if (selectedDate < minDate) {
        //         alert('La fecha de nacimiento no puede ser hace más de 100 años.');
        //         this.value = '';
        //     }
        // });

        // Validación de contraseña
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        
        function validatePassword() {
            if (password.value !== passwordConfirmation.value) {
                passwordConfirmation.setCustomValidity('Las contraseñas no coinciden');
            } else {
                passwordConfirmation.setCustomValidity('');
            }
        }

        password.addEventListener('input', validatePassword);
        passwordConfirmation.addEventListener('input', validatePassword);

        // Prevenir envío duplicado
        form.addEventListener('submit', function() {
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creando...';
        });

        // // Generar contraseña sugerida
        // function generateSuggestedPassword() {
        //     const length = 12;
        //     const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
        //     let password = "";
        //     for (let i = 0; i < length; i++) {
        //         password += charset.charAt(Math.floor(Math.random() * charset.length));
        //     }
        //     return password;
        // }

    //     // Botón para generar contraseña
    //     const generatePasswordBtn = document.createElement('button');
    //     generatePasswordBtn.type = 'button';
    //     generatePasswordBtn.className = 'mt-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded text-sm';
    //     generatePasswordBtn.innerHTML = '<i class="fas fa-key mr-1"></i>Generar Contraseña';
    //     generatePasswordBtn.addEventListener('click', function() {
    //         const suggestedPassword = generateSuggestedPassword();
    //         password.value = suggestedPassword;
    //         passwordConfirmation.value = suggestedPassword;
    //         validatePassword();
    //     });

    //     password.parentNode.appendChild(generatePasswordBtn);
    // });
</script>
@endpush
@endsection