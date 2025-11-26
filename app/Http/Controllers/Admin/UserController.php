<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // LISTADO
    public function index()
    {
        $users = User::with('role')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    // FORM CREAR
    public function create()
    {
        $roles = Role::all(); // admin, staff, client
        return view('admin.users.create', compact('roles'));
    }

    // GUARDAR NUEVO
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'role_id'  => ['required', 'exists:roles,id'],
            'is_active'=> ['nullable', 'boolean'],
        ]);

        $data['password']  = Hash::make($data['password']);
        $data['is_active'] = $request->boolean('is_active', true);

        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    // FORM EDITAR
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    // ACTUALIZAR
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email,' . $user->id],
            'role_id'  => ['required', 'exists:roles,id'],
            'is_active'=> ['nullable', 'boolean'],
            'password' => ['nullable', 'min:6'],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->boolean('is_active', true);

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    // DESACTIVAR (no borrar físico)
    public function destroy(User $user)
    {
        // Prohibir desactivar/eliminar al usuario administrador
        if ($user->role && $user->role->name === 'admin') {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Acción prohibida: no se puede desactivar al usuario administrador.');
        }

        $user->update(['is_active' => false]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario desactivado correctamente.');
    }

    // REACTIVAR
    public function activate(User $user)
    {
        $user->update(['is_active' => true]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario reactivado correctamente.');
    }

    // ELIMINAR (borrado físico)
    public function forceDelete(User $user)
    {
        // Prohibir eliminar al usuario administrador
        if ($user->role && $user->role->name === 'admin') {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Acción prohibida: no se puede eliminar al usuario administrador.');
        }

        $user->forceDelete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
