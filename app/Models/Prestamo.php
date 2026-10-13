<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Libro;

class Prestamo extends Model
{
    protected $table = 'prestamos';

    protected $fillable = [
        'fecha_prestamo',
        'fecha_devolucion',
        'fecha_entrega',
        'estado',
        'user_id',
        'libro_id',
    ];

    protected $casts = [
        'fecha_prestamo' => 'date',
        'fecha_devolucion' => 'date',
        'fecha_entrega' => 'date',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function libro(): BelongsTo
    {
        return $this->belongsTo(Libro::class, 'libro_id');
    }
}