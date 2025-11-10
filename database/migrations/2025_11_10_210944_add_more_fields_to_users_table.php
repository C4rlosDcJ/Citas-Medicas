<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Campos adicionales para usuarios
            $table->string('telefono')->nullable()->after('email');
            $table->string('direccion')->nullable()->after('telefono');
            $table->date('fecha_nacimiento')->nullable()->after('direccion');
            $table->enum('genero', ['masculino', 'femenino', 'otro'])->nullable()->after('fecha_nacimiento');
            $table->string('cedula')->nullable()->after('genero');
            $table->boolean('activo')->default(true)->after('role_id');
            $table->text('notas')->nullable()->after('activo');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'telefono',
                'direccion',
                'fecha_nacimiento',
                'genero',
                'cedula',
                'activo',
                'notas'
            ]);
        });
    }
};