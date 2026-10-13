<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Prestamo;
use App\Models\Categoria;
use App\Models\Editorial;


class Libro extends Model
{
    protected $table = 'libros';

    protected $fillable = [
        'titulo',
        'isbn',
        'anio_publicacion',
        'cantidad',
        'disponibles',
        'categoria_id',
        'autor',
        'editorial_id',
        'descripcion',
        'estado',
    ];

    protected $casts = [
        'anio_publicacion' => 'integer',
        'cantidad' => 'integer',
        'disponibles' => 'integer',
        'categoria_id' => 'integer',
        'estado' => 'boolean',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'libro_id');
    }

    public function editorial(): BelongsTo
    {
        return $this->belongsTo(Editorial::class, 'editorial_id');
    }
}