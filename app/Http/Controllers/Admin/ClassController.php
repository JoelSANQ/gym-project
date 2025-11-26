<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GymClass;
use App\Models\User;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = GymClass::with('trainer')->paginate(10);
        return view('admin.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trainers = User::where('role_id', function ($query) {
            $query->select('id')->from('roles')->where('name', 'staff');
        })->get();
        
        return view('admin.classes.create', compact('trainers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'capacity' => ['required', 'integer', 'min:1'],
            'schedule' => ['required', 'string', 'max:255'],
            'trainer_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        GymClass::create($data);

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Clase creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GymClass $class)
    {
        return view('admin.classes.show', compact('class'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GymClass $class)
    {
        $trainers = User::where('role_id', function ($query) {
            $query->select('id')->from('roles')->where('name', 'staff');
        })->get();
        
        return view('admin.classes.edit', compact('class', 'trainers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GymClass $class)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'capacity' => ['required', 'integer', 'min:1'],
            'schedule' => ['required', 'string', 'max:255'],
            'trainer_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $class->update($data);

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Clase actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GymClass $class)
    {
        $class->update(['is_active' => false]);

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Clase desactivada correctamente.');
    }

    /**
     * Reactivate a class
     */
    public function activate(GymClass $class)
    {
        $class->update(['is_active' => true]);

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Clase reactivada correctamente.');
    }
}
