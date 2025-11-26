<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;

class MemberController extends Controller
{
    public function index()
    {
        $clientRole = Role::where('name', 'client')->first();
        $members = User::where('role_id', $clientRole->id)
            ->with('memberships')
            ->paginate(15);

        return view('staff.members.index', compact('members'));
    }

    public function show(User $member)
    {
        $clientRole = Role::where('name', 'client')->first();
        
        if ($member->role_id !== $clientRole->id) {
            abort(403, 'No tienes permiso para ver este usuario.');
        }

        return view('staff.members.show', compact('member'));
    }
}
