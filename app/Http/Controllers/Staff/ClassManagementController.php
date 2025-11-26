<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\GymClass;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class ClassManagementController extends Controller
{
    // Solo ver clases activas, no puede crear/editar (eso es para admin)
    public function index()
    {
        $classes = GymClass::where('is_active', true)
            ->with('trainer')
            ->paginate(10);

        return view('staff.classes.index', compact('classes'));
    }

    public function show(GymClass $class)
    {
        return view('staff.classes.show', compact('class'));
    }
}
