<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Staff\StaffDashboardController;
use App\Http\Controllers\Client\ClientDashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard general - redirige según el rol del usuario
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if (!$user) {
        return view('dashboard');
    }
    
    $role = $user->role->name ?? null;
    
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'staff') {
        return redirect()->route('staff.dashboard');
    } elseif ($role === 'client') {
        return redirect()->route('client.dashboard');
    }
    
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ============================================
// RUTAS ADMIN - Control total del sistema
// ============================================
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Gestión de Usuarios
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/activate', [UserController::class, 'activate'])
            ->name('users.activate');
        Route::delete('users/{user}/force-delete', [UserController::class, 'forceDelete'])
            ->name('users.forceDelete');

        // TODO: Gestión de Clases, Membresías, Pagos y Reportes
    });

// ============================================
// RUTAS STAFF - Empleado / Recepcionista / Entrenador
// ============================================
Route::middleware(['auth', 'verified', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])
            ->name('dashboard');

        // TODO: Ver socios, registrar entradas, pagos, administrar clases
    });

// ============================================
// RUTAS CLIENT - Cliente / Socio del gimnasio
// ============================================
Route::middleware(['auth', 'verified', 'role:client'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {
        Route::get('/dashboard', [ClientDashboardController::class, 'index'])
            ->name('dashboard');

        // TODO: Ver membresía, historial de pagos, asistencia
    });
