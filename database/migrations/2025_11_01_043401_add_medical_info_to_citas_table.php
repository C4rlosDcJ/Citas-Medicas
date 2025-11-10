<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('citas', function (Blueprint $table) {
            // Información médica
            $table->text('diagnostico')->nullable()->after('notas');
            $table->text('tratamiento')->nullable()->after('diagnostico');
            $table->text('medicamentos_recetados')->nullable()->after('tratamiento');
            $table->text('recomendaciones')->nullable()->after('medicamentos_recetados');
            $table->text('observaciones')->nullable()->after('recomendaciones');
            $table->enum('seguimiento', ['ninguno', 'control', 'especialista', 'urgencias'])->default('ninguno')->after('observaciones');
            $table->date('proxima_cita')->nullable()->after('seguimiento');
            $table->decimal('temperatura', 4, 2)->nullable()->after('proxima_cita');
            $table->integer('presion_arterial_sistolica')->nullable()->after('temperatura');
            $table->integer('presion_arterial_diastolica')->nullable()->after('presion_arterial_sistolica');
            $table->integer('frecuencia_cardiaca')->nullable()->after('presion_arterial_diastolica');
            $table->integer('frecuencia_respiratoria')->nullable()->after('frecuencia_cardiaca');
            $table->decimal('peso', 5, 2)->nullable()->after('frecuencia_respiratoria');
            $table->decimal('altura', 3, 2)->nullable()->after('peso');
            $table->decimal('imc', 4, 2)->nullable()->after('altura');
        });
    }

    public function down()
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropColumn([
                'diagnostico',
                'tratamiento',
                'medicamentos_recetados',
                'recomendaciones',
                'observaciones',
                'seguimiento',
                'proxima_cita',
                'temperatura',
                'presion_arterial_sistolica',
                'presion_arterial_diastolica',
                'frecuencia_cardiaca',
                'frecuencia_respiratoria',
                'peso',
                'altura',
                'imc'
            ]);
        });
    }
};