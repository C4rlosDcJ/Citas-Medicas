<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id', 
        'medico_id', 
        'fecha_hora', 
        'estado', 
        'tipo_cita',
        'duracion',
        'prioridad',
        'motivo_consulta', 
        'sintomas',
        'es_primera_vez',
        'referido_por',
        'alergias_notas',
        'medicamentos_actuales',
        'notas',
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
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
        'proxima_cita' => 'date',
        'temperatura' => 'decimal:2',
        'peso' => 'decimal:2',
        'altura' => 'decimal:2',
        'imc' => 'decimal:2',
        'es_primera_vez' => 'boolean',
        'duracion' => 'integer',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    // Calcular IMC automáticamente
    public function calcularIMC()
    {
        if ($this->peso && $this->altura) {
            $this->imc = $this->peso / ($this->altura * $this->altura);
        }
        return $this->imc;
    }

    // Obtener clasificación del IMC
    public function getClasificacionIMCAttribute()
    {
        if (!$this->imc) return null;

        if ($this->imc < 18.5) return 'Bajo peso';
        if ($this->imc < 25) return 'Normal';
        if ($this->imc < 30) return 'Sobrepeso';
        if ($this->imc < 35) return 'Obesidad grado I';
        if ($this->imc < 40) return 'Obesidad grado II';
        return 'Obesidad grado III';
    }

    // Obtener presión arterial formateada
    public function getPresionArterialAttribute()
    {
        if ($this->presion_arterial_sistolica && $this->presion_arterial_diastolica) {
            return "{$this->presion_arterial_sistolica}/{$this->presion_arterial_diastolica} mmHg";
        }
        return null;
    }
}