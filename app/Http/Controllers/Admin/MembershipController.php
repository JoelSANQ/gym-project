<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::with('user')->paginate(10);
        return view('admin.memberships.index', compact('memberships'));
    }

    public function create()
    {
        $clientRole = Role::where('name', 'client')->first();
        $clients = User::where('role_id', $clientRole->id)->get();
        return view('admin.memberships.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'plan_name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->has('is_active');

        Membership::create($data);

        return redirect()
            ->route('admin.memberships.index')
            ->with('success', 'Membresía creada correctamente.');
    }

    public function edit(Membership $membership)
    {
        $clientRole = Role::where('name', 'client')->first();
        $clients = User::where('role_id', $clientRole->id)->get();
        return view('admin.memberships.edit', compact('membership', 'clients'));
    }

    public function update(Request $request, Membership $membership)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'plan_name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->has('is_active');

        $membership->update($data);

        return redirect()
            ->route('admin.memberships.index')
            ->with('success', 'Membresía actualizada correctamente.');
    }

    public function destroy(Membership $membership)
    {
        $membership->delete();

        return redirect()
            ->route('admin.memberships.index')
            ->with('success', 'Membresía eliminada correctamente.');
    }
}
