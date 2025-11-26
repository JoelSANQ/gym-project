<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class ClientDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('client.dashboard', compact('user'));
    }
}
