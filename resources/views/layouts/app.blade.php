<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Citas Médicas')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    
    @auth
    <!-- Navigation -->
    <nav class="bg-white shadow-md sticky top-0 z-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                <!-- Logo y marca -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 group">
                        <div class="bg-gradient-to-r from-primary-500 to-primary-600 p-2 rounded-lg shadow-sm group-hover:shadow-md transition-all duration-300">
                            <i class="fas fa-heartbeat text-white text-xl"></i>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-primary-600 to-primary-700 bg-clip-text text-transparent">
                            Clínica Salud
                        </span>
                    </a>
                    
                    <!-- Navegación central - Desktop -->
                    <div class="hidden lg:flex items-center space-x-1">
                        <a href="{{ route('dashboard') }}" 
                           class="nav-link flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200">
                            <i class="fas fa-tachometer-alt"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('citas.index') }}" 
                           class="nav-link flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200">
                            <i class="fas fa-calendar-check"></i>
                            <span class="font-medium">
                                @if(auth()->user()->isPaciente())
                                    Mis Citas
                                @else
                                    Gestión de Citas
                                @endif
                            </span>
                        </a>

                        <a href="{{ route('citas.create') }}" 
                           class="nav-link flex items-center space-x-2 px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition-all duration-200 shadow-sm hover:shadow">
                            <i class="fas fa-plus"></i>
                            <span class="font-medium">Nueva Cita</span>
                        </a>

                        @if(auth()->user()->isMedico() || auth()->user()->isAdmin())
                        <a href="{{ route('pacientes.index') }}" 
                           class="nav-link flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200">
                            <i class="fas fa-users"></i>
                            <span class="font-medium">Pacientes</span>
                        </a>
                        @endif

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('users.index') }}" class=" hover:bg-blue-500 px-3 py-2 rounded-md transition duration-300 flex items-center">
                                <i class="fas fa-users-cog mr-1"></i>Usuarios
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Usuario y logout -->
                <div class="flex items-center space-x-4">
                    <!-- Badge del rol -->
                    <div class="hidden md:flex items-center space-x-3">
                        <span class="px-3 py-1.5 text-xs font-semibold rounded-full flex items-center space-x-1.5
                            @if(auth()->user()->isAdmin()) 
                                bg-purple-100 text-purple-700 ring-1 ring-purple-200
                            @elseif(auth()->user()->isMedico()) 
                                bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200
                            @else 
                                bg-blue-100 text-blue-700 ring-1 ring-blue-200
                            @endif">
                            <i class="fas 
                                @if(auth()->user()->isAdmin()) fa-crown
                                @elseif(auth()->user()->isMedico()) fa-user-md
                                @else fa-user
                                @endif">
                            </i>
                            <span>
                                @if(auth()->user()->isAdmin())
                                    Administrador
                                @elseif(auth()->user()->isMedico())
                                    Médico
                                @else
                                    Paciente
                                @endif
                            </span>
                        </span>
                    </div>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-red-50 hover:text-red-600 transition-all duration-200">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="hidden md:inline font-medium">Salir</span>
                        </button>
                    </form>

                    <!-- Mobile menu button -->
                    <button type="button" 
                            id="mobile-menu-button"
                            class="lg:hidden p-2 rounded-lg text-gray-700 hover:bg-gray-100 transition-all duration-200">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-gray-200 bg-white">
            <div class="px-4 py-3 space-y-1">
                <!-- User info mobile -->
                <div class="flex items-center space-x-3 pb-3 mb-3 border-b border-gray-200">
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-500 flex items-center space-x-1">
                            <span class="px-2 py-0.5 rounded-full text-xs
                                @if(auth()->user()->isAdmin()) bg-purple-100 text-purple-700
                                @elseif(auth()->user()->isMedico()) bg-emerald-100 text-emerald-700
                                @else bg-blue-100 text-blue-700
                                @endif">
                                @if(auth()->user()->isAdmin())
                                    Administrador
                                @elseif(auth()->user()->isMedico())
                                    Médico
                                @else
                                    Paciente
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('dashboard') }}" 
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('citas.index') }}" 
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200">
                    <i class="fas fa-calendar-check w-5"></i>
                    <span class="font-medium">
                        @if(auth()->user()->isPaciente())
                            Mis Citas
                        @else
                            Gestión de Citas
                        @endif
                    </span>
                </a>

                <a href="{{ route('citas.create') }}" 
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition-all duration-200">
                    <i class="fas fa-plus w-5"></i>
                    <span class="font-medium">Nueva Cita</span>
                </a>

                @if(auth()->user()->isMedico() || auth()->user()->isAdmin())
                <a href="{{ route('pacientes.index') }}" 
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200">
                    <i class="fas fa-users w-5"></i>
                    <span class="font-medium">Pacientes</span>
                </a>
                @endif

            </div>
        </div>
    </nav>
    @endauth

    <!-- Page Content -->
    <main class="@auth py-8 @else min-h-screen @endauth">
        @yield('content')
    </main>

    <!-- Footer -->
    @auth
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Información de la clínica -->
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="bg-primary-500 p-2 rounded-lg">
                            <i class="fas fa-heartbeat text-white text-lg"></i>
                        </div>
                        <h3 class="text-xl font-bold">Clínica Salud</h3>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Sistema de gestión de citas médicas. Cuidando tu salud con tecnología de vanguardia y atención personalizada.
                    </p>
                    <div class="flex space-x-3 mt-4">
                        <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-800 hover:bg-primary-600 transition-all duration-200">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-800 hover:bg-primary-600 transition-all duration-200">
                            <i class="fab fa-twitter text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-800 hover:bg-primary-600 transition-all duration-200">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Enlaces rápidos -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-link mr-2 text-primary-400"></i>
                        Enlaces Rápidos
                    </h3>
                    <ul class="space-y-2.5">
                        <li>
                            <a href="{{ route('dashboard') }}" 
                               class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-xs text-primary-400 group-hover:translate-x-1 transition-transform duration-200"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('citas.index') }}" 
                               class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-xs text-primary-400 group-hover:translate-x-1 transition-transform duration-200"></i>
                                @if(auth()->user()->isPaciente())
                                    Mis Citas
                                @else
                                    Gestión de Citas
                                @endif
                            </a>
                        </li>
                        @if(auth()->user()->isMedico() || auth()->user()->isAdmin())
                        <li>
                            <a href="{{ route('pacientes.index') }}" 
                               class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-xs text-primary-400 group-hover:translate-x-1 transition-transform duration-200"></i>
                                Pacientes
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>

                <!-- Información de contacto -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-phone mr-2 text-primary-400"></i>
                        Contacto
                    </h3>
                    <div class="space-y-3">
                        <a href="tel:+15551234567" class="flex items-center text-gray-400 hover:text-white transition-colors duration-200 group">
                            <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-800 group-hover:bg-primary-600 transition-all duration-200 mr-3">
                                <i class="fas fa-phone text-sm"></i>
                            </div>
                            <span class="text-sm">+1 (555) 123-4567</span>
                        </a>
                        <a href="mailto:info@clinicasalud.com" class="flex items-center text-gray-400 hover:text-white transition-colors duration-200 group">
                            <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-800 group-hover:bg-primary-600 transition-all duration-200 mr-3">
                                <i class="fas fa-envelope text-sm"></i>
                            </div>
                            <span class="text-sm">info@clinicasalud.com</span>
                        </a>
                        <div class="flex items-start text-gray-400 group">
                            <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-800 mr-3 flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-sm"></i>
                            </div>
                            <span class="text-sm">Av. Principal #123, Ciudad</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="border-t border-gray-800 mt-8 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
                    <p class="text-gray-400 text-sm">
                        &copy; {{ date('Y') }} Clínica Salud. Todos los derechos reservados.
                    </p>
                    <div class="flex items-center space-x-1 text-gray-500 text-xs">
                        <span>Desarrollado con</span>
                        <i class="fas fa-heart text-red-500 text-xs mx-1"></i>
                        <span>usando Laravel y Tailwind CSS</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @endauth

    <div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                    const icon = this.querySelector('i');
                    icon.classList.toggle('fa-bars');
                    icon.classList.toggle('fa-times');
                });
            }

            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('bg-primary-50', 'text-primary-700');
                }
            });

            @if(session('success'))
                showNotification('{{ session('success') }}', 'success');
            @endif

            @if(session('error'))
                showNotification('{{ session('error') }}', 'error');
            @endif

            document.querySelectorAll('form[data-confirm]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const message = this.getAttribute('data-confirm');
                    if (!confirm(message)) {
                        e.preventDefault();
                    }
                });
            });
        });

        function showNotification(message, type = 'success') {
            const container = document.getElementById('notification-container');
            const notification = document.createElement('div');
            
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                info: 'fa-info-circle',
                warning: 'fa-exclamation-triangle'
            };

            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                info: 'bg-blue-500',
                warning: 'bg-yellow-500'
            };

            notification.className = `${colors[type]} text-white px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 ease-out translate-x-0 opacity-100 min-w-[300px] max-w-md`;
            notification.innerHTML = `
                <div class="flex items-start space-x-3">
                    <i class="fas ${icons[type]} text-xl flex-shrink-0 mt-0.5"></i>
                    <div class="flex-1">
                        <p class="font-medium">${message}</p>
                    </div>
                    <button onclick="removeNotification(this)" class="flex-shrink-0 hover:bg-white/20 rounded p-1 transition-colors duration-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            container.appendChild(notification);

            setTimeout(() => {
                removeNotification(notification);
            }, 5000);
        }

        function removeNotification(element) {
            const notification = element.closest ? element.closest('div[class*="bg-"]') : element.parentElement.parentElement;
            notification.style.transform = 'translateX(400px)';
            notification.style.opacity = '0';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }
    </script>

    <style>
        * {
            transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        html {
            scroll-behavior: smooth;
        }

        button:focus, a:focus, input:focus, select:focus, textarea:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
            border-radius: 0.375rem;
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            position: sticky;
            top: 0;
            background-color: #f9fafb;
            z-index: 10;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .loading {
            opacity: 0.6;
            pointer-events: none;
            position: relative;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #3b82f6;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spinner 0.6s linear infinite;
        }

        @keyframes spinner {
            to { transform: rotate(360deg); }
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</body>
</html>