@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-users-cog text-purple-500 mr-2"></i>Gestión de Usuarios
                </h1>
                <p class="text-gray-600 mt-1">Administra todos los usuarios del sistema</p>
            </div>
            <a href="{{ route('users.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-300 flex items-center">
                <i class="fas fa-user-plus mr-2"></i>Nuevo Usuario
            </a>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white border-l-4 border-purple-500 rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="bg-purple-100 p-3 rounded-full mr-4">
                        <i class="fas fa-users text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Usuarios</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $users->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-blue-500 rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <i class="fas fa-user-md text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Médicos</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $users->where('role_id', 2)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-green-500 rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-full mr-4">
                        <i class="fas fa-user-injured text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Pacientes</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $users->where('role_id', 3)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-red-500 rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="bg-red-100 p-3 rounded-full mr-4">
                        <i class="fas fa-user-shield text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Administradores</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $users->where('role_id', 1)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Usuarios -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            @if($users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Usuario
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contacto
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rol
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha Registro
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition duration-300">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-{{ $user->role_id == 1 ? 'purple' : ($user->role_id == 2 ? 'blue' : 'green') }}-100 rounded-full flex items-center justify-center">
                                            <i class="fas {{ $user->role_id == 1 ? 'fa-user-shield text-purple-600' : ($user->role_id == 2 ? 'fa-user-md text-blue-600' : 'fa-user-injured text-green-600') }} text-sm"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $user->name }}
                                                @if($user->id === auth()->id())
                                                    <span class="ml-2 text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">Tú</span>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->telefono }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->direccion ? Str::limit($user->direccion, 30) : 'Sin dirección' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($user->role_id == 1) bg-purple-100 text-purple-800
                                        @elseif($user->role_id == 2) bg-blue-100 text-blue-800
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ $user->role->nombre }}
                                    </span>
                                    @if($user->medico)
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $user->medico->especialidad->nombre }}
                                    </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($user->activo) bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $user->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'Sin fecha' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('users.show', $user) }}" class="text-blue-600 hover:text-blue-900 p-2 rounded-full hover:bg-blue-50 transition duration-300" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('users.edit', $user) }}" class="text-green-600 hover:text-green-900 p-2 rounded-full hover:bg-green-50 transition duration-300" title="Editar usuario">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('users.toggle-status', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-{{ $user->activo ? 'yellow' : 'green' }}-600 hover:text-{{ $user->activo ? 'yellow' : 'green' }}-900 p-2 rounded-full hover:bg-{{ $user->activo ? 'yellow' : 'green' }}-50 transition duration-300" title="{{ $user->activo ? 'Desactivar' : 'Activar' }} usuario">
                                                <i class="fas {{ $user->activo ? 'fa-pause' : 'fa-play' }}"></i>
                                            </button>
                                        </form>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este usuario?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 p-2 rounded-full hover:bg-red-50 transition duration-300" title="Eliminar usuario">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-users-slash text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay usuarios registrados</h3>
                    <p class="text-gray-500 mb-4">No se encontraron usuarios en el sistema.</p>
                    <a href="{{ route('users.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-300 inline-flex items-center">
                        <i class="fas fa-user-plus mr-2"></i>Crear Primer Usuario
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection