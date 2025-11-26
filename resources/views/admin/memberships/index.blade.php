<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Membresías') }}
            </h2>
            <a href="{{ route('admin.memberships.create') }}"
               class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 text-sm font-medium">
                + Nueva Membresía
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($memberships->count())
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Cliente</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Plan</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Precio</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Vigencia</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Estado</th>
                                        <th class="px-4 py-3 text-right font-semibold text-gray-700">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach ($memberships as $membership)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $membership->user->name }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700">
                                                {{ $membership->plan_name }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700">
                                                ${{ number_format($membership->price, 2) }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700">
                                                {{ $membership->start_date->format('d/m/Y') }} - {{ $membership->end_date->format('d/m/Y') }}
                                            </td>
                                            <td class="px-4 py-3">
                                                @if ($membership->is_active)
                                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-semibold">Activa</span>
                                                @else
                                                    <span class="px-3 py-1 bg-slate-100 text-slate-800 rounded-full text-xs font-semibold">Inactiva</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <a href="{{ route('admin.memberships.edit', $membership) }}"
                                                   class="text-blue-600 hover:text-blue-800 font-medium text-sm mr-3">
                                                    Editar
                                                </a>
                                                <form action="{{ route('admin.memberships.destroy', $membership) }}"
                                                      method="POST" class="inline"
                                                      onsubmit="return confirm('¿Eliminar membresía?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $memberships->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No hay membresías registradas.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
