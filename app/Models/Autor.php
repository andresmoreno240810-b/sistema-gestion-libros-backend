<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'autors';

    protected $fillable = [
        'nombre',
        'apellido',
        'nacionalidad',
        'fecha_nacimiento',
        'estado',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'estado' => 'boolean',
    ];
}