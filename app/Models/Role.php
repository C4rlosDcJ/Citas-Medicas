<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles'; // Especificar el nombre de la tabla

    protected $fillable = ['nombre', 'descripcion'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}