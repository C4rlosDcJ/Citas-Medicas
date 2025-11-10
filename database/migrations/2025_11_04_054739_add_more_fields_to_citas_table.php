<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('citas', function (Blueprint $table) {
            // Nuevos campos para la cita
            $table->enum('tipo_cita', ['consulta', 'control', 'emergencia', 'seguimiento'])->default('consulta')->after('estado');
            $table->integer('duracion')->default(30)->after('tipo_cita'); // en minutos
            $table->string('prioridad')->default('normal')->after('duracion'); // baja, normal, alta, urgente
            $table->text('sintomas')->nullable()->after('prioridad');
            $table->boolean('es_primera_vez')->default(true)->after('sintomas');
            $table->string('referido_por')->nullable()->after('es_primera_vez');
            $table->text('alergias_notas')->nullable()->after('referido_por');
            $table->text('medicamentos_actuales')->nullable()->after('alergias_notas');
        });
    }

    public function down()
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropColumn([
                'tipo_cita',
                'duracion',
                'prioridad',
                'sintomas',
                'es_primera_vez',
                'referido_por',
                'alergias_notas',
                'medicamentos_actuales'
            ]);
        });
    }
};