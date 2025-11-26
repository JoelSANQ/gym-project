<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Socios del Gimnasio') }}
            </h2>

            <span class="text-sm text-gray-500">
                Total: {{ $members->total() }} socio(s)
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Card principal --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Listado de Socios</h3>
                        <p class="text-sm text-gray-500">
                            Consulta información de los socios registrados.
                        </p>
                    </div>
                </div>

                {{-- Tabla --}}
                <div class="px-6 py-4 overflow-x-auto">
                    @if ($members->count())
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Membresía</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-3 py-2 text-right font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($members as $member)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 text-gray-700">
                                            #{{ $member->id }}
                                        </td>

                                        <td class="px-3 py-2">
                                            <div class="flex flex-col">
                                                <span class="text-gray-900 font-medium">
                                                    {{ $member->name }}
                                                </span>
                                                <span class="text-xs text-gray-400">
                                                    {{ $member->created_at?->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="px-3 py-2 text-gray-700">
                                            {{ $member->email }}
                                        </td>

                                        <td class="px-3 py-2">
                                            @if ($member->memberships()->where('is_active', true)->first())
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    {{ $member->memberships()->where('is_active', true)->first()->plan_name }}
                                                </span>
                                            @else
                                                <span class="text-gray-500 text-xs">Sin membresía</span>
                                            @endif
                                        </td>

                                        <td class="px-3 py-2">
                                            @if ($member->is_active)
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
                                            <a href="{{ route('staff.members.show', $member) }}"
                                               class="text-indigo-600 hover:text-indigo-800 text-xs font-medium">
                                                Ver detalles
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="py-10 text-center text-sm text-gray-500">
                            No hay socios registrados aún.
                        </div>
                    @endif
                </div>

                {{-- Paginación --}}
                <div class="px-6 py-3 border-t border-gray-100">
                    {{ $members->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
