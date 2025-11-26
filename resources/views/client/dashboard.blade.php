{{-- resources/views/profile/panel.blade.php (o similar) --}}
<x-app-layout> 
    <x-slot name="header">
        @php($user = auth()->user())
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
                    {{ __('Mi Panel') }}
                </h2>
                <p class="text-sm text-gray-500">
                    Resumen de tu cuenta en el gimnasio
                </p>
            </div>

            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $user->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-700 border border-slate-300' }}">
                <span class="mr-1.5 h-2 w-2 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                {{ $user->is_active ? 'Cuenta activa' : 'Cuenta inactiva' }}
            </span>
        </div>
    </x-slot>

    @php($user = auth()->user())

    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- FILA 1: 3 tarjetas de “estadísticas” tipo dashboard --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                {{-- Card 1: Perfil --}}
                <a href="{{ route('profile.edit') }}"
                   class="group bg-white rounded-xl shadow-sm border border-gray-200 hover:border-emerald-400 hover:shadow-md transition-all">
                    <div class="px-5 py-4 flex items-center gap-4">
                        <div class="h-12 w-12 rounded-xl bg-emerald-50 flex items-center justify-center">
                            <span class="text-2xl text-emerald-500">👤</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600">
                                    Perfil
                                </p>
                                <span class="text-[11px] text-emerald-500 font-semibold group-hover:text-emerald-600">
                                    Editar →
                                </span>
                            </div>
                            <p class="mt-1 text-base font-semibold text-gray-900">
                                {{ $user->name }}
                            </p>
                            <p class="text-xs text-gray-500">
                                Gestiona tus datos de acceso.
                            </p>
                        </div>
                    </div>
                </a>

                        {{-- Card 2: Membresía --}}
                        <a href="{{ route('client.memberships.index') }}" class="group bg-white rounded-xl shadow-sm border border-gray-200 hover:border-sky-400 hover:shadow-md transition-all">
                            <div class="px-5 py-4 flex items-center gap-4">
                                <div class="h-12 w-12 rounded-xl bg-sky-50 flex items-center justify-center">
                                    <span class="text-2xl text-sky-500">🎫</span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-sky-600">
                                            Membresía
                                        </p>
                                        <span class="text-[11px] text-sky-500 font-semibold group-hover:text-sky-600">
                                            Ver →
                                        </span>
                                    </div>
                                    <p class="mt-1 text-base font-semibold text-gray-900">
                                        {{ auth()->user()->memberships()->where('is_active', true)->first()?->plan_name ?? 'Sin plan' }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Tu plan y vencimiento.
                                    </p>
                                </div>
                            </div>
                        </a>                {{-- Card 3: Asistencia / Pagos --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-5 py-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-purple-600">
                            Tu Actividad
                        </p>
                        <div class="mt-3 space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Visitas este mes</span>
                                <span class="text-lg font-bold text-purple-900">{{ auth()->user()->attendance()->whereMonth('check_in', now()->month)->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Total visitas</span>
                                <span class="text-lg font-bold text-purple-900">{{ auth()->user()->attendance()->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Pagos</span>
                                <span class="text-lg font-bold text-purple-900">{{ auth()->user()->payments()->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                    <a href="{{ route('client.attendance.index') }}" class="group bg-white rounded-xl shadow-sm border border-gray-200 hover:border-orange-400 hover:shadow-md transition-all">
                        <div class="px-5 py-4 flex items-center gap-4">
                            <div class="h-12 w-12 rounded-xl bg-orange-50 flex items-center justify-center">
                                <span class="text-2xl text-orange-500">📊</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-orange-600">
                                        Asistencia
                                    </p>
                                    <span class="text-[11px] text-orange-500 font-semibold group-hover:text-orange-600">
                                        Ver →
                                    </span>
                                </div>
                                <p class="mt-1 text-base font-semibold text-gray-900">
                                    {{ auth()->user()->attendance()->count() }} visitas
                                </p>
                                <p class="text-xs text-gray-500">
                                    Tu historial de entradas.
                                </p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('client.payments.index') }}" class="group bg-white rounded-xl shadow-sm border border-gray-200 hover:border-red-400 hover:shadow-md transition-all">
                        <div class="px-5 py-4 flex items-center gap-4">
                            <div class="h-12 w-12 rounded-xl bg-red-50 flex items-center justify-center">
                                <span class="text-2xl text-red-500">💳</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-red-600">
                                        Pagos
                                    </p>
                                    <span class="text-[11px] text-red-500 font-semibold group-hover:text-red-600">
                                        Ver →
                                    </span>
                                </div>
                                <p class="mt-1 text-base font-semibold text-gray-900">
                                    {{ auth()->user()->payments()->count() }} registros
                                </p>
                                <p class="text-xs text-gray-500">
                                    Tu historial de transacciones.
                                </p>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('client.classes.index') }}" class="group bg-white rounded-xl shadow-sm border border-gray-200 hover:border-indigo-400 hover:shadow-md transition-all">
                        <div class="px-5 py-4 flex items-center gap-4">
                            <div class="h-12 w-12 rounded-xl bg-indigo-50 flex items-center justify-center">
                                <span class="text-2xl text-indigo-500">🏷️</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-indigo-600">
                                        Mis Clases
                                    </p>
                                    <span class="text-[11px] text-indigo-500 font-semibold group-hover:text-indigo-600">
                                        Ver →
                                    </span>
                                </div>
                                <p class="mt-1 text-base font-semibold text-gray-900">
                                    Ver clases a las que te has anotado
                                </p>
                                <p class="text-xs text-gray-500">
                                    Historial de inscripciones y últimas asistencias.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

            </div>

            {{-- FILA 2: layout tipo “cards de contenido” como el tablero central --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

         
</x-app-layout>
