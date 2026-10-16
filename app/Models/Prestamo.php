
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    // Relación anterior: se conserva temporalmente
    // para no romper el código existente.
    public function libro(): BelongsTo
    {
        return $this->belongsTo(Libro::class, 'libro_id');
    }

    // Todos los detalles asociados al préstamo.
    public function detalles(): HasMany
    {
        return $this->hasMany(DetallePrestamo::class, 'prestamo_id');
    }

    // Todos los libros incluidos en el préstamo.
    public function libros(): BelongsToMany
    {
        return $this->belongsToMany(
            Libro::class,
            'detalle_prestamos',
            'prestamo_id',
            'libro_id'
        )->withPivot('cantidad')->withTimestamps();
    }
}
