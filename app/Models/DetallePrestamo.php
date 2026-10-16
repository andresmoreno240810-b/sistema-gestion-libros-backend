<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetallePrestamo extends Model
{
    protected $table = 'detalle_prestamos';

    protected $fillable = [
        'prestamo_id',
        'libro_id',
        'cantidad',
    ];

    protected $casts = [
        'cantidad' => 'integer',
    ];

    public function prestamo(): BelongsTo
    {
        return $this->belongsTo(Prestamo::class, 'prestamo_id');
    }

    public function libro(): BelongsTo
    {
        return $this->belongsTo(Libro::class, 'libro_id');
    }
}
