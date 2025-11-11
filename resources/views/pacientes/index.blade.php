@extends('layouts.app')

@section('title', 'Lista de Pacientes')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-users text-green-500 mr-2"></i>Lista de Pacientes
                </h1>
                <p class="text-gray-600 mt-1">Gestiona la información de los pacientes del sistema</p>
            </div>
            <a href="{{ route('citas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-300 flex items-center">
                <i class="fas fa-plus mr-2"></i>Nueva Cita
            </a>
        </div>

        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            @if($pacientes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Paciente
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contacto
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Edad
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Alergias
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Antecedentes
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pacientes as $paciente)
                            <tr class="hover:bg-gray-50 transition duration-300">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="bg-blue-100 p-2 rounded-full mr-3">
                                            <i class="fas fa-user text-blue-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $paciente->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $paciente->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $paciente->telefono }}</div>
                                    <div class="text-sm text-gray-500">{{ $paciente->direccion ? Str::limit($paciente->direccion, 30) : 'Sin dirección' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $paciente->fecha_nacimiento->age }} años
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs">
                                        @if($paciente->alergias)
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">
                                                {{ Str::limit($paciente->alergias, 30) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">Ninguna</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs">
                                        @if($paciente->antecedentes_medicos)
                                            {{ Str::limit($paciente->antecedentes_medicos, 40) }}
                                        @else
                                            <span class="text-gray-400">Ninguno</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('citas.create') }}?paciente_id={{ $paciente->id }}" 
                                           class="text-blue-600 hover:text-blue-900 p-2 rounded-full hover:bg-blue-50 transition duration-300"
                                           title="Crear cita para este paciente">
                                            <i class="fas fa-calendar-plus"></i>
                                        </a>
                                        <!-- <button class="text-green-600 hover:text-green-900 p-2 rounded-full hover:bg-green-50 transition duration-300"
                                                title="Ver historial">
                                            <i class="fas fa-history"></i>
                                        </button> -->
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
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay pacientes registrados</h3>
                    <p class="text-gray-500">No se encontraron pacientes en el sistema.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection