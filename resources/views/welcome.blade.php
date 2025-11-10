<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Citas Médicas - Clínica Salud</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="/" class="flex items-center group">
                        <div class="h-12 w-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-heartbeat text-white text-xl"></i>
                        </div>
                        <span class="ml-3 text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            Clínica Salud
                        </span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-sign-in-alt mr-2"></i>Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-2 rounded-lg font-medium shadow-lg transform hover:scale-105 transition-all duration-200">
                        <i class="fas fa-user-plus mr-2"></i>Registrarse
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="pt-32 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="fade-in-up">
                    <div class="inline-flex items-center px-4 py-2 bg-blue-100 rounded-full text-blue-700 text-sm font-medium mb-6">
                        <i class="fas fa-star mr-2"></i>
                        Sistema de Gestión Médica #1
                    </div>
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Tu salud,
                        <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            siempre prioritaria
                        </span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Gestiona tus citas médicas de manera inteligente. Agenda, modifica y consulta tus citas cuando lo necesites, desde cualquier dispositivo.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="group bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-8 py-4 rounded-xl font-semibold text-lg shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                            <i class="fas fa-rocket mr-2 group-hover:translate-x-1 transition-transform"></i>
                            Comenzar Ahora
                        </a>
                        <a href="#features" class="border-2 border-gray-300 text-gray-700 hover:border-blue-600 hover:text-blue-600 px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-200 flex items-center justify-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            Conocer Más
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="mt-12 grid grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">500+</div>
                            <div class="text-sm text-gray-600 mt-1">Pacientes</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-indigo-600">50+</div>
                            <div class="text-sm text-gray-600 mt-1">Médicos</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600">98%</div>
                            <div class="text-sm text-gray-600 mt-1">Satisfacción</div>
                        </div>
                    </div>
                </div>

                <!-- Right Image/Illustration -->
                <div class="relative float-animation">
                    <div class="bg-gradient-to-br from-blue-400 to-indigo-500 rounded-3xl p-8 shadow-2xl transform rotate-3">
                        <div class="bg-white rounded-2xl p-8 transform -rotate-3">
                            <div class="space-y-4">
                                <!-- Mock appointment card -->
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 bg-blue-600 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user-md text-white"></i>
                                            </div>
                                            <div class="ml-3">
                                                <div class="font-semibold text-gray-900">Dr. Juan Pérez</div>
                                                <div class="text-sm text-gray-600">Cardiología</div>
                                            </div>
                                        </div>
                                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600 mt-3">
                                        <i class="fas fa-calendar mr-2 text-blue-600"></i>
                                        15 Nov, 2024 - 10:00 AM
                                    </div>
                                </div>

                                <!-- Mock appointment card 2 -->
                                <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-4 rounded-xl border border-purple-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 bg-purple-600 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user-md text-white"></i>
                                            </div>
                                            <div class="ml-3">
                                                <div class="font-semibold text-gray-900">Dra. María López</div>
                                                <div class="text-sm text-gray-600">Medicina General</div>
                                            </div>
                                        </div>
                                        <i class="fas fa-clock text-orange-500 text-xl"></i>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600 mt-3">
                                        <i class="fas fa-calendar mr-2 text-purple-600"></i>
                                        20 Nov, 2024 - 3:00 PM
                                    </div>
                                </div>

                                <!-- Quick stats -->
                                <div class="grid grid-cols-2 gap-3 mt-4">
                                    <div class="bg-green-50 p-3 rounded-lg border border-green-200 text-center">
                                        <div class="text-2xl font-bold text-green-600">12</div>
                                        <div class="text-xs text-gray-600">Completadas</div>
                                    </div>
                                    <div class="bg-blue-50 p-3 rounded-lg border border-blue-200 text-center">
                                        <div class="text-2xl font-bold text-blue-600">3</div>
                                        <div class="text-xs text-gray-600">Pendientes</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-20 bg-white/50 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    ¿Por qué elegirnos?
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Ofrecemos la mejor experiencia en gestión de citas médicas con tecnología de punta
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="h-16 w-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-calendar-check text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 text-center">Agenda Rápida</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Agenda tus citas médicas en segundos. Sistema disponible 24/7 para tu comodidad.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="h-16 w-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-user-md text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 text-center">Médicos Expertos</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Accede a nuestra red de médicos certificados y especialistas en diversas áreas.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="h-16 w-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-bell text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 text-center">Recordatorios Smart</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Recibe notificaciones automáticas para que nunca olvides tus citas importantes.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="h-16 w-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 text-center">100% Responsive</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Accede desde cualquier dispositivo: móvil, tablet o computadora.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="h-16 w-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 text-center">Datos Seguros</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Tu información médica está protegida con los más altos estándares de seguridad.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="h-16 w-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-history text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 text-center">Historial Completo</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Consulta tu historial médico y citas anteriores en cualquier momento.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <div class="h-10 w-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-heartbeat text-white"></i>
                        </div>
                        <span class="ml-3 text-xl font-bold">Clínica Salud</span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Sistema integral de gestión de citas médicas. Tu salud es nuestra prioridad.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="h-10 w-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="h-10 w-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="h-10 w-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h3 class="font-bold mb-4">Enlaces Rápidos</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Nosotros</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Servicios</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Especialidades</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contacto</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="font-bold mb-4">Contacto</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2 text-blue-500"></i>
                            +52 55 1234 5678
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2 text-blue-500"></i>
                            info@clinicasalud.com
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                            Ciudad de México
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center">
                <p class="text-gray-400">
                    &copy; 2025 Clínica Salud. Todos los derechos reservados.
                </p>
                <p class="text-gray-500 mt-2 text-sm">
                    Sistema desarrollado con <i class="fas fa-heart text-red-500"></i> usando Laravel y Tailwind CSS
                </p>
            </div>
        </div>
    </footer>
</body>
</html>