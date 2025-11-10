@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Card Principal -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header con gradiente -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-10">
                <div class="flex justify-center mb-4">
                    <div class="h-16 w-16 bg-white rounded-2xl flex items-center justify-center shadow-lg transform transition-transform hover:scale-110 duration-300">
                        <i class="fas fa-user-md text-blue-600 text-2xl"></i>
                    </div>
                </div>
                <h2 class="text-center text-3xl font-bold text-white">
                    Bienvenido
                </h2>
                <p class="mt-2 text-center text-blue-100">
                    Ingresa a tu cuenta para continuar
                </p>
            </div>

            <!-- Contenido del formulario -->
            <div class="px-8 py-8">
                <!-- Mostrar errores generales -->
                @if($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-3"></i>
                            <div class="flex-1">
                                <ul class="text-sm text-red-700 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form class="space-y-5" action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Correo Electrónico
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror"
                                   placeholder="tu@email.com" value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-2 flex items-center">
                                <i class="fas fa-info-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror"
                                   placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-2 flex items-center">
                                <i class="fas fa-info-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Botón de submit -->
                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-[1.02]">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Iniciar Sesión
                        </button>
                    </div>
                </form>

                <!-- Link de registro -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        ¿No tienes una cuenta?
                        <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                            Regístrate aquí
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection