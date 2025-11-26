<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\GymClass;
use Illuminate\Http\Request;

class EnrolledClassController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Obtener las clases a las que el usuario tiene registros de asistencia (attendance)
        $classIds = $user->attendance()->pluck('class_id')->filter()->unique()->toArray();

        $classes = GymClass::with('schedules')
            ->whereIn('id', $classIds)
            ->get();

        return view('client.classes.index', compact('classes'));
    }
}
