<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Membresía') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Membresía Activa --}}
            @if ($activeMembership)
                <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 border-2 border-emerald-300 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-emerald-900">{{ $activeMembership->plan_name }}</h3>
                            <p class="text-sm text-emerald-700 mt-1">Plan activo</p>
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-bold text-emerald-900">${{ number_format($activeMembership->price, 2) }}</p>
                            <p class="text-xs text-emerald-700">por mes</p>
                        </div>
                    </div>

                    @if ($activeMembership->description)
                        <p class="text-emerald-800 mb-4">{{ $activeMembership->description }}</p>
                    @endif

                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <p class="text-xs text-emerald-700 uppercase font-semibold">Inicio</p>
                            <p class="text-lg font-bold text-emerald-900">{{ $activeMembership->start_date->format('d/m/Y') }}</p>
                        </div>

                        @if ($activeMembership->end_date)
                            <div>
                                <p class="text-xs text-emerald-700 uppercase font-semibold">Vencimiento</p>
                                <p class="text-lg font-bold text-emerald-900">{{ $activeMembership->end_date->format('d/m/Y') }}</p>
                            </div>

                            <div>
                                <p class="text-xs text-emerald-700 uppercase font-semibold">Días restantes</p>
                                <p class="text-lg font-bold text-emerald-900">
                                    {{ now()->diffInDays($activeMembership->end_date) }}
                                </p>
                            </div>
                        @else
                            <div>
                                <p class="text-xs text-emerald-700 uppercase font-semibold">Duración</p>
                                <p class="text-lg font-bold text-emerald-900">Sin límite</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-6 text-center">
                    <p class="text-gray-600 font-semibold mb-2">No tienes membresía activa</p>
                    <p class="text-sm text-gray-500">Contacta con administración para contratar una membresía.</p>
                </div>
            @endif

            {{-- Historial de Membresías --}}
            @if ($memberships->count())
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Historial de Membresías</h3>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @foreach ($memberships as $membership)
                            <div class="px-6 py-4 hover:bg-gray-50 transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">{{ $membership->plan_name }}</h4>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ $membership->start_date->format('d/m/Y') }}
                                            @if ($membership->end_date)
                                                - {{ $membership->end_date->format('d/m/Y') }}
                                            @else
                                                - Sin vencimiento
                                            @endif
                                        </p>
                                    </div>

                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">${{ number_format($membership->price, 2) }}/mes</p>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-2
                                            {{ $membership->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $membership->is_active ? 'Activa' : 'Inactiva' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
