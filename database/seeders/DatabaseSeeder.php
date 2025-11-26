<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\GymClass;
use App\Models\Membership;
use App\Models\Attendance;
use App\Models\ClassSchedule;
use App\Models\Payment;
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
        $admin = User::firstOrCreate(
            ['email' => 'admin@gimnasio.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('12345678'),
                'role_id' => $adminRole->id,
                'is_active' => true,
            ]
        );

        // Usuario de prueba (cliente)
        $client = User::firstOrCreate(
            ['email' => 'cliente@example.com'],
            [
                'name' => 'Cliente de Prueba',
                'password' => Hash::make('12345678'),
                'role_id' => $clientRole->id,
                'is_active' => true,
            ]
        );

        // Usuario staff (empleado/entrenador)
        $trainer = User::firstOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Personal del Gimnasio',
                'password' => Hash::make('12345678'),
                'role_id' => $staffRole->id,
                'is_active' => true,
            ]
        );

        // Crear algunas clases de prueba
        $yoga = GymClass::firstOrCreate(
            ['name' => 'Yoga Matutino'],
            [
                'description' => 'Clase de yoga relajante para comenzar el día',
                'capacity' => 15,
                'schedule' => 'Lunes, Miércoles, Viernes 6:00 AM - 7:00 AM',
                'trainer_id' => $trainer->id,
                'is_active' => true,
            ]
        );

        $crossfit = GymClass::firstOrCreate(
            ['name' => 'CrossFit'],
            [
                'description' => 'Entrenamiento de alta intensidad',
                'capacity' => 20,
                'schedule' => 'Martes, Jueves, Sábado 6:00 PM - 7:00 PM',
                'trainer_id' => $trainer->id,
                'is_active' => true,
            ]
        );

        GymClass::firstOrCreate(
            ['name' => 'Spinning'],
            [
                'description' => 'Clase de ciclismo indoor',
                'capacity' => 25,
                'schedule' => 'Lunes, Miércoles 7:00 PM - 8:00 PM',
                'trainer_id' => null,
                'is_active' => true,
            ]
        );

        // Crear horarios para Yoga (Lunes, Miércoles, Viernes)
        ClassSchedule::firstOrCreate(
            ['class_id' => $yoga->id, 'day_of_week' => 1],
            ['day_name' => 'Lunes', 'start_time' => '06:00:00', 'end_time' => '07:00:00']
        );
        ClassSchedule::firstOrCreate(
            ['class_id' => $yoga->id, 'day_of_week' => 3],
            ['day_name' => 'Miércoles', 'start_time' => '06:00:00', 'end_time' => '07:00:00']
        );
        ClassSchedule::firstOrCreate(
            ['class_id' => $yoga->id, 'day_of_week' => 5],
            ['day_name' => 'Viernes', 'start_time' => '06:00:00', 'end_time' => '07:00:00']
        );

        // Crear horarios para CrossFit (Martes, Jueves, Sábado)
        ClassSchedule::firstOrCreate(
            ['class_id' => $crossfit->id, 'day_of_week' => 2],
            ['day_name' => 'Martes', 'start_time' => '18:00:00', 'end_time' => '19:00:00']
        );
        ClassSchedule::firstOrCreate(
            ['class_id' => $crossfit->id, 'day_of_week' => 4],
            ['day_name' => 'Jueves', 'start_time' => '18:00:00', 'end_time' => '19:00:00']
        );
        ClassSchedule::firstOrCreate(
            ['class_id' => $crossfit->id, 'day_of_week' => 6],
            ['day_name' => 'Sábado', 'start_time' => '18:00:00', 'end_time' => '19:00:00']
        );

        // Crear horarios para Spinning (Lunes, Miércoles)
        $spinning = GymClass::where('name', 'Spinning')->first();
        ClassSchedule::firstOrCreate(
            ['class_id' => $spinning->id, 'day_of_week' => 1],
            ['day_name' => 'Lunes', 'start_time' => '19:00:00', 'end_time' => '20:00:00']
        );
        ClassSchedule::firstOrCreate(
            ['class_id' => $spinning->id, 'day_of_week' => 3],
            ['day_name' => 'Miércoles', 'start_time' => '19:00:00', 'end_time' => '20:00:00']
        );

        // Crear membresía para el cliente
        $membership = Membership::firstOrCreate(
            ['user_id' => $client->id, 'plan_name' => 'Premium'],
            [
                'price' => 99.99,
                'description' => 'Acceso ilimitado a todas las clases + piscina',
                'start_date' => now()->startOfMonth(),
                'end_date' => now()->addMonths(3),
                'is_active' => true,
            ]
        );

        // Crear registros de asistencia
        Attendance::firstOrCreate(
            ['user_id' => $client->id, 'class_id' => $yoga->id, 'check_in' => now()->subDays(5)->setTime(6, 0)],
            [
                'check_out' => now()->subDays(5)->setTime(7, 0),
            ]
        );

        Attendance::firstOrCreate(
            ['user_id' => $client->id, 'class_id' => $crossfit->id, 'check_in' => now()->subDays(3)->setTime(18, 0)],
            [
                'check_out' => now()->subDays(3)->setTime(19, 0),
            ]
        );

        Attendance::firstOrCreate(
            ['user_id' => $client->id, 'class_id' => $yoga->id, 'check_in' => now()->subDays(1)->setTime(6, 0)],
            [
                'check_out' => now()->subDays(1)->setTime(7, 0),
            ]
        );

        // Crear pagos
        Payment::firstOrCreate(
            ['user_id' => $client->id, 'concept' => 'Membresía Premium '],
            [
                'membership_id' => $membership->id,
                'amount' => 350.00,
                'payment_method' => 'card',
                'status' => 'completed',
                'payment_date' => now()->subDays(30),
            ]
        );

        Payment::firstOrCreate(
            ['user_id' => $client->id, 'concept' => 'Membresía Estandar'],
            [
                'membership_id' => $membership->id,
                'amount' => 650.00,
                'payment_method' => 'transfer',
                'status' => 'completed',
                'payment_date' => now()->subDays(15),
            ]
        );

        Payment::firstOrCreate(
            ['user_id' => $client->id, 'concept' => 'Clase adicional'],
            [
                'membership_id' => null,
                'amount' => 100.00,
                'payment_method' => 'cash',
                'status' => 'completed',
                'payment_date' => now()->subDays(5),
            ]
        );
    }
}
