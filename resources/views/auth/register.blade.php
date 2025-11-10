@extends('layouts.app')

@section('title', 'Registrarse')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full">
        <!-- Card Principal -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header con gradiente -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-8">
                <div class="flex justify-center mb-4">
                    <div class="h-16 w-16 bg-white rounded-2xl flex items-center justify-center shadow-lg transform transition-transform hover:scale-110 duration-300">
                        <i class="fas fa-user-plus text-blue-600 text-2xl"></i>
                    </div>
                </div>
                <h2 class="text-center text-3xl font-bold text-white">
                    Crear Cuenta
                </h2>
                <p class="mt-2 text-center text-blue-100">
                    Complete el formulario para registrarse
                </p>
            </div>

            <!-- Contenido del formulario -->
            <div class="px-8 py-8">
                <form class="space-y-6" action="{{ route('register') }}" method="POST">
                    @csrf

                    <!-- Sección: Información Personal -->
                    <div>
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                            </div>
                            <h3 class="ml-3 text-lg font-semibold text-gray-900">Información Personal</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nombre Completo -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nombre Completo *
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-id-card text-gray-400"></i>
                                    </div>
                                    <input id="name" name="name" type="text" required 
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror"
                                           placeholder="Juan Pérez González" value="{{ old('name') }}">
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-2 flex items-center">
                                        <i class="fas fa-info-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="md:col-span-2">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Correo Electrónico *
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input id="email" name="email" type="email" autocomplete="email" required 
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror"
                                           placeholder="correo@ejemplo.com" value="{{ old('email') }}">
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-2 flex items-center">
                                        <i class="fas fa-info-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Fecha de Nacimiento -->
                            <div>
                                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-2">
                                    Fecha de Nacimiento *
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                    </div>
                                    <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" required 
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('fecha_nacimiento') border-red-500 @enderror"
                                           value="{{ old('fecha_nacimiento') }}">
                                </div>
                                @error('fecha_nacimiento')
                                    <p class="text-red-500 text-xs mt-2 flex items-center">
                                        <i class="fas fa-info-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                                    Teléfono *
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                    <input id="telefono" name="telefono" type="tel" required 
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('telefono') border-red-500 @enderror"
                                           placeholder="55 1234 5678" value="{{ old('telefono') }}">
                                </div>
                                @error('telefono')
                                    <p class="text-red-500 text-xs mt-2 flex items-center">
                                        <i class="fas fa-info-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Dirección -->
                            <div class="md:col-span-2">
                                <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">
                                    Dirección
                                </label>
                                <div class="relative">
                                    <div class="absolute top-3 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </div>
                                    <textarea id="direccion" name="direccion" rows="2"
                                              class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                              placeholder="Calle, número, colonia, ciudad">{{ old('direccion') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Separador -->
                    <div class="border-t border-gray-200"></div>

                    <!-- Sección: Seguridad -->
                    <div>
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-lock text-indigo-600 text-sm"></i>
                                </div>
                            </div>
                            <h3 class="ml-3 text-lg font-semibold text-gray-900">Seguridad</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Contraseña -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Contraseña *
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-key text-gray-400"></i>
                                    </div>
                                    <input id="password" name="password" type="password" required 
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror"
                                           placeholder="••••••••">
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-2 flex items-center">
                                        <i class="fas fa-info-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirmar Contraseña *
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-check-circle text-gray-400"></i>
                                    </div>
                                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                           placeholder="••••••••">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Separador -->
                    <div class="border-t border-gray-200"></div>

                    <!-- Sección: Información Médica -->
                    <div>
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-heartbeat text-purple-600 text-sm"></i>
                                </div>
                            </div>
                            <h3 class="ml-3 text-lg font-semibold text-gray-900">Información Médica</h3>
                            <span class="ml-2 text-sm text-gray-500">(Opcional)</span>
                        </div>

                        <div class="space-y-4">
                            <!-- Alergias -->
                            <div>
                                <label for="alergias" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alergias
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-exclamation-triangle text-gray-400"></i>
                                    </div>
                                    <input id="alergias" name="alergias" type="text" 
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                           placeholder="Ej: Penicilina, Polen, Mariscos" value="{{ old('alergias') }}">
                                </div>
                            </div>

                            <!-- Antecedentes Médicos -->
                            <div>
                                <label for="antecedentes_medicos" class="block text-sm font-medium text-gray-700 mb-2">
                                    Antecedentes Médicos
                                </label>
                                <div class="relative">
                                    <div class="absolute top-3 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-file-medical text-gray-400"></i>
                                    </div>
                                    <textarea id="antecedentes_medicos" name="antecedentes_medicos" rows="3"
                                              class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                              placeholder="Describa cirugías previas, enfermedades crónicas, medicamentos actuales, etc.">{{ old('antecedentes_medicos') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botón de submit -->
                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-[1.02]">
                            <i class="fas fa-user-plus mr-2"></i>
                            Crear Cuenta
                        </button>
                    </div>

                    <!-- Link de login -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            ¿Ya tienes una cuenta?
                            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                                Inicia sesión aquí
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Nota informativa -->
        <div class="mt-6 bg-white/80 backdrop-blur-sm rounded-xl p-5 shadow-md border border-gray-100">
            <div class="flex items-start">
                <i class="fas fa-shield-alt text-blue-500 mt-1 mr-3"></i>
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-1">Protección de Datos</h4>
                    <p class="text-xs text-gray-600">
                        Su información médica es confidencial y está protegida según las normas de privacidad aplicables. 
                        Los campos marcados con * son obligatorios.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection