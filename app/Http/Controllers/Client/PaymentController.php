<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $payments = $user->payments()
            ->with('membership')
            ->latest('payment_date')
            ->paginate(15);

        $stats = $this->getStats($user);

        return view('client.payments.index', compact('payments', 'stats'));
    }

    private function getStats($user)
    {
        $currentMonth = now()->startOfMonth();
        $currentYear = now()->year;

        $totalThisMonth = $user->payments()
            ->whereYear('payment_date', $currentYear)
            ->whereMonth('payment_date', now()->month)
            ->where('status', 'completed')
            ->sum('amount');

        $totalAllTime = $user->payments()
            ->where('status', 'completed')
            ->sum('amount');

        return [
            'total_this_month' => $totalThisMonth,
            'total_all_time' => $totalAllTime,
        ];
    }
}
