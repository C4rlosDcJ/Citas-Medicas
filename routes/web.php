<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PacienteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Citas Routes - Accesible para todos los roles autenticados
    Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
    Route::get('/citas/create', [CitaController::class, 'create'])->name('citas.create');
    Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
    Route::get('/citas/{cita}', [CitaController::class, 'show'])->name('citas.show');
    Route::get('/citas/{cita}/edit', [CitaController::class, 'edit'])->name('citas.edit');
    Route::patch('/citas/{cita}/medical', [CitaController::class, 'updateMedical'])->name('citas.update-medical');
    Route::patch('/citas/{cita}/status', [CitaController::class, 'updateStatus'])->name('citas.update-status');

    // Pacientes Routes - Para médicos y admin
    Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
});