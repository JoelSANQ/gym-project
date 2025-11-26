<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $attendance = $user->attendance()
            ->with('class')
            ->latest('check_in')
            ->paginate(15);

        $monthlyStats = $this->getMonthlyStats($user);

        return view('client.attendance.index', compact('attendance', 'monthlyStats'));
    }

    private function getMonthlyStats($user)
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $count = Attendance::where('user_id', $user->id)
            ->whereYear('check_in', $currentYear)
            ->whereMonth('check_in', $currentMonth)
            ->count();

        return [
            'current_month' => $count,
            'month_name' => now()->format('F Y'),
        ];
    }
}
