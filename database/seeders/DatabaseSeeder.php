<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear roles si no existen
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        // Crear usuario ADMIN autorizado
        User::firstOrCreate(
            ['email' => 'admin@gimnasio.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('Admin123456'),
                'role_id' => $adminRole->id,
                'is_active' => true,
            ]
        );

        // Usuario de prueba (cliente)
        User::firstOrCreate(
            ['email' => 'cliente@example.com'],
            [
                'name' => 'Cliente de Prueba',
                'password' => Hash::make('Cliente123456'),
                'role_id' => $clientRole->id,
                'is_active' => true,
            ]
        );

        // Usuario staff (empleado)
        User::firstOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Personal del Gimnasio',
                'password' => Hash::make('Staff123456'),
                'role_id' => $staffRole->id,
                'is_active' => true,
            ]
        );
    }
}
