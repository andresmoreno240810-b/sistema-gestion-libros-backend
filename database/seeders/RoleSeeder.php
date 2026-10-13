<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'nombre' => 'Administrador',
            'descripcion' => 'Control total del sistema',
            'estado' => true
        ]);

        Role::create([
            'nombre' => 'Lector',
            'descripcion' => 'Usuario que solicita préstamos de libros',
            'estado' => true
        ]);
    }
}