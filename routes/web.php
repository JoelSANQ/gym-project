<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\MembershipController as AdminMembershipController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Staff\StaffDashboardController;
use App\Http\Controllers\Staff\MemberController;
use App\Http\Controllers\Staff\AttendanceCheckInController;
use App\Http\Controllers\Staff\PaymentRegistrationController;
use App\Http\Controllers\Staff\ClassManagementController;
use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\Client\MembershipController;
use App\Http\Controllers\Client\AttendanceController;
use App\Http\Controllers\Client\PaymentController;

Route::get('/', function () {
    return redirect()->route('login');
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

        // Gestión de Clases
        Route::resource('classes', ClassController::class);
        Route::patch('classes/{class}/activate', [ClassController::class, 'activate'])
            ->name('classes.activate');

        // Gestión de Membresías
        Route::resource('memberships', AdminMembershipController::class);

        // Gestión de Pagos
        Route::resource('payments', AdminPaymentController::class);
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

        // Ver socios
        Route::resource('members', MemberController::class)->only(['index', 'show']);

        // Registrar entradas
        Route::get('/attendance', [AttendanceCheckInController::class, 'index'])
            ->name('attendance.index');
        Route::post('/attendance', [AttendanceCheckInController::class, 'store'])
            ->name('attendance.store');
        Route::patch('/attendance/{attendance}/check-out', [AttendanceCheckInController::class, 'checkOut'])
            ->name('attendance.checkOut');

        // Registrar pagos
        Route::get('/payments', [PaymentRegistrationController::class, 'index'])
            ->name('payments.index');
        Route::post('/payments', [PaymentRegistrationController::class, 'store'])
            ->name('payments.store');

        // Ver clases (solo lectura)
        Route::resource('classes', ClassManagementController::class)->only(['index', 'show']);
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

        // Membresías
        Route::get('/memberships', [MembershipController::class, 'index'])
            ->name('memberships.index');
        Route::get('/memberships/{membership}', [MembershipController::class, 'show'])
            ->name('memberships.show');

        // Asistencia
        Route::get('/attendance', [AttendanceController::class, 'index'])
            ->name('attendance.index');

        // Pagos
        Route::get('/payments', [PaymentController::class, 'index'])
            ->name('payments.index');
    });
