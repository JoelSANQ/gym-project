{{-- resources/views/admin/users/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Usuarios del Gimnasio') }}
            </h2>

            <span class="text-sm text-gray-500">
                Total: {{ $users->total() }} usuario(s)
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Alertas --}}
            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-md text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Card principal --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Listado de usuarios</h3>
                        <p class="text-sm text-gray-500">
                            Administra los accesos al sistema del gimnasio.
                        </p>
                    </div>

                    <a href="{{ route('admin.users.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        + Nuevo usuario
                    </a>
                </div>

                {{-- Tabla --}}
                <div class="px-6 py-4 overflow-x-auto">
                    @if ($users->count())
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-3 py-2 text-right font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 text-gray-700">
                                            #{{ $user->id }}
                                        </td>

                                        <td class="px-3 py-2">
                                            <div class="flex flex-col">
                                                <span class="text-gray-900 font-medium">
                                                    {{ $user->name }}
                                                </span>
                                                <span class="text-xs text-gray-400">
                                                    {{ $user->created_at?->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="px-3 py-2 text-gray-700">
                                            {{ $user->email }}
                                        </td>

                                        <td class="px-3 py-2">
                                            @php
                                                $roleName = $user->role->name ?? 'SIN ROL';
                                            @endphp

                                            @if ($roleName === 'admin')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Admin
                                                </span>
                                            @elseif ($roleName === 'staff')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Staff
                                                </span>
                                            @elseif ($roleName === 'client')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                                    Cliente
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                    SIN ROL
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-3 py-2">
                                            @if ($user->is_active)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    Activo
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                                    Inactivo
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-3 py-2 text-right space-x-2">
                                            {{-- Editar --}}
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                               class="text-indigo-600 hover:text-indigo-800 text-xs font-medium">
                                                Editar
                                            </a>

                                            @if($user->is_active)
                                                {{-- Desactivar --}}
                                                <form action="{{ route('admin.users.destroy', $user) }}"
                                                      method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('¿Desactivar este usuario?')"
                                                        class="text-red-600 hover:text-red-800 text-xs font-medium">
                                                        Desactivar
                                                    </button>
                                                </form>
                                            @else
                                                {{-- Reactivar --}}
                                                <form action="{{ route('admin.users.activate', $user) }}"
                                                      method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        onclick="return confirm('¿Reactivar este usuario?')"
                                                        class="text-emerald-600 hover:text-emerald-800 text-xs font-medium">
                                                        Reactivar
                                                    </button>
                                                </form>

                                                {{-- Eliminar --}}
                                                <form action="{{ route('admin.users.forceDelete', $user) }}"
                                                      method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('¿Eliminar permanentemente este usuario? Esta acción no se puede deshacer.')"
                                                        class="text-red-600 hover:text-red-800 text-xs font-medium">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="py-10 text-center text-sm text-gray-500">
                            No hay usuarios registrados aún.
                        </div>
                    @endif
                </div>

                {{-- Paginación --}}
                <div class="px-6 py-3 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
