<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'genero',
        'cedula',
        'notas',
        'activo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'fecha_nacimiento' => 'date',
            'activo' => 'boolean',
        ];
    }

    // Valor por defecto para activo
    protected $attributes = [
        'activo' => true,
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function medico()
    {
        return $this->hasOne(Medico::class);
    }

    public function paciente()
    {
        return $this->hasOne(Paciente::class);
    }

    public function isAdmin()
    {
        return $this->role_id === 1;
    }

    public function isMedico()
    {
        return $this->role_id === 2;
    }

    public function isPaciente()
    {
        return $this->role_id === 3;
    }
}