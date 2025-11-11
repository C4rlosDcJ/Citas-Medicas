<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Verificar si las columnas no existen antes de agregarlas
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->foreignId('role_id')->default(3)->constrained('roles')->after('password');
            }
            if (!Schema::hasColumn('users', 'telefono')) {
                $table->string('telefono', 20)->nullable()->after('role_id');
            }
            if (!Schema::hasColumn('users', 'direccion')) {
                $table->string('direccion', 500)->nullable()->after('telefono');
            }
            if (!Schema::hasColumn('users', 'fecha_nacimiento')) {
                $table->date('fecha_nacimiento')->nullable()->after('direccion');
            }
            if (!Schema::hasColumn('users', 'genero')) {
                $table->enum('genero', ['masculino', 'femenino', 'otro'])->nullable()->after('fecha_nacimiento');
            }
            if (!Schema::hasColumn('users', 'cedula')) {
                $table->string('cedula', 20)->nullable()->after('genero');
            }
            if (!Schema::hasColumn('users', 'notas')) {
                $table->text('notas')->nullable()->after('cedula');
            }
            if (!Schema::hasColumn('users', 'activo')) {
                $table->boolean('activo')->default(true)->after('notas');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role_id',
                'telefono',
                'direccion',
                'fecha_nacimiento',
                'genero',
                'cedula',
                'notas',
                'activo'
            ]);
        });
    }
};