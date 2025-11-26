<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $memberships = $user->memberships()->latest()->get();
        $activeMembership = $user->memberships()->where('is_active', true)->first();

        return view('client.memberships.index', compact('memberships', 'activeMembership'));
    }

    public function show(Membership $membership)
    {
        $this->authorize('view', $membership);
        return view('client.memberships.show', compact('membership'));
    }
}
