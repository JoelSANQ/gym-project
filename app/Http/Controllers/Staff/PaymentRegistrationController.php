<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use App\Models\Role;
use App\Models\Membership;
use Illuminate\Http\Request;

class PaymentRegistrationController extends Controller
{
    public function index()
    {
        $clientRole = Role::where('name', 'client')->first();
        $members = User::where('role_id', $clientRole->id)->get();
        $payments = Payment::latest('payment_date')->paginate(20);

        return view('staff.payments.index', compact('members', 'payments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'concept' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', 'in:cash,card,transfer,check'],
            'payment_date' => ['required', 'date'],
            'status' => ['required', 'in:pending,completed,failed'],
            'notes' => ['nullable', 'string'],
            'membership_id' => ['nullable', 'exists:memberships,id'],
        ]);

        Payment::create($data);

        return redirect()
            ->route('staff.payments.index')
            ->with('success', 'Pago registrado correctamente.');
    }
}
