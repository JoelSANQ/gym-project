<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use App\Models\Role;
use App\Models\Membership;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('user', 'membership')->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        $clientRole = Role::where('name', 'client')->first();
        $clients = User::where('role_id', $clientRole->id)->get();
        $memberships = Membership::where('is_active', true)->get();
        return view('admin.payments.create', compact('clients', 'memberships'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'membership_id' => ['nullable', 'exists:memberships,id'],
            'concept' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'in:cash,card,transfer,check'],
            'status' => ['required', 'in:pending,completed,failed'],
            'payment_date' => ['required', 'date'],
        ]);

        Payment::create($data);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Pago registrado correctamente.');
    }

    public function edit(Payment $payment)
    {
        $clientRole = Role::where('name', 'client')->first();
        $clients = User::where('role_id', $clientRole->id)->get();
        $memberships = Membership::where('is_active', true)->get();
        return view('admin.payments.edit', compact('payment', 'clients', 'memberships'));
    }

    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'membership_id' => ['nullable', 'exists:memberships,id'],
            'concept' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'in:cash,card,transfer,check'],
            'status' => ['required', 'in:pending,completed,failed'],
            'payment_date' => ['required', 'date'],
        ]);

        $payment->update($data);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Pago actualizado correctamente.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Pago eliminado correctamente.');
    }
}
