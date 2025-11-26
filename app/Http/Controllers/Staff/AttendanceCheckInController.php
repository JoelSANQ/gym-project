<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use App\Models\GymClass;
use App\Models\Role;
use Illuminate\Http\Request;

class AttendanceCheckInController extends Controller
{
    public function index()
    {
        $clientRole = Role::where('name', 'client')->first();
        $members = User::where('role_id', $clientRole->id)->get();
        $classes = GymClass::where('is_active', true)->get();

        return view('staff.attendance.index', compact('members', 'classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'class_id' => ['required', 'exists:classes,id'],
            'check_in' => ['required', 'date_format:Y-m-d H:i'],
        ]);

        $data['check_in'] = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $data['check_in']);

        Attendance::create($data);

        return redirect()
            ->route('staff.attendance.index')
            ->with('success', 'Entrada registrada correctamente.');
    }

    public function checkOut(Attendance $attendance)
    {
        $attendance->update(['check_out' => now()]);

        return redirect()
            ->route('staff.attendance.index')
            ->with('success', 'Salida registrada correctamente.');
    }
}
