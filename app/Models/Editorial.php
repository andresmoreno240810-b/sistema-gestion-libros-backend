<?php

namespace App\Models;

use App\Models\Libro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Editorial extends Model
{
    protected $table = 'editorials';

    protected $fillable = [
        'nombre',
    ];

    public function libros(): HasMany
    {
        return $this->hasMany(Libro::class, 'editorial_id');
    }
}