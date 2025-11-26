<x-app-layout> 
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
                    {{ __('Mi Panel') }}
                </h2>
                <p class="text-sm text-gray-500">
                    Resumen de tu cuenta en el gimnasio
                </p>
            </div>

            @php($user = auth()->user())
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $user->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                <span class="mr-1.5 h-2 w-2 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                {{ $user->is_active ? 'Cuenta activa' : 'Cuenta inactiva' }}
            </span>
        </div>
    </x-slot>

    @php($user = auth()->user())

    <div class="py-10 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Tarjeta de resumen principal --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 px-6 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold tracking-widest text-indigo-500 uppercase mb-1">
                        Bienvenido de vuelta
                    </p>
                    <h3 class="text-2xl font-bold text-gray-900">
                        {{ $user->name }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Mantén tu información actualizada y revisa el estado de tu perfil como socio.
                    </p>
                </div>

                <div class="flex flex-col items-start md:items-end gap-2 text-sm">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold text-gray-500">Rol:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                            {{ optional($user->role)->name ? ucfirst($user->role->name) : 'Sin rol asignado' }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-semibold text-gray-500">Email:</span>
                        <span class="text-gray-700">{{ $user->email }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Columna izquierda: menú tipo “secciones” --}}
                <div class="space-y-4">

                    {{-- Mi Perfil (activo) --}}
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-4 bg-white rounded-2xl border border-indigo-100 shadow-sm hover:shadow-md hover:border-indigo-300 transition-all p-4">
                        <div class="h-12 w-12 rounded-xl bg-indigo-50 flex items-center justify-center text-2xl">
                            👤
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">Mi Perfil</h4>
                            <p class="text-sm text-gray-500">Ver y editar tu información personal y de acceso.</p>
                        </div>
                        <span class="text-xs text-indigo-500 font-semibold">
                            Abrir →
                        </span>
                    </a>

                    {{-- Mi Membresía --}}
                    <div class="flex items-center gap-4 bg-white rounded-2xl border border-gray-200 shadow-sm p-4 opacity-80">
                        <div class="h-12 w-12 rounded-xl bg-yellow-50 flex items-center justify-center text-2xl">
                            🎫
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">Mi Membresía</h4>
                            <p class="text-sm text-gray-500">
                                Próximamente podrás ver tu plan, vencimiento y beneficios.
                            </p>
                        </div>
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-500 border border-gray-200">
                            En desarrollo
                        </span>
                    </div>

                    {{-- Historial de Pagos --}}
                    <div class="flex items-center gap-4 bg-white rounded-2xl border border-gray-200 shadow-sm p-4 opacity-80">
                        <div class="h-12 w-12 rounded-xl bg-emerald-50 flex items-center justify-center text-2xl">
                            💳
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">Historial de Pagos</h4>
                            <p class="text-sm text-gray-500">
                                Aquí verás tus pagos realizados y próximos cargos.
                            </p>
                        </div>
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-500 border border-gray-200">
                            Próximamente
                        </span>
                    </div>

                    {{-- Mi Asistencia --}}
                    <div class="flex items-center gap-4 bg-white rounded-2xl border border-gray-200 shadow-sm p-4 opacity-80">
                        <div class="h-12 w-12 rounded-xl bg-sky-50 flex items-center justify-center text-2xl">
                            📊
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">Mi Asistencia</h4>
                            <p class="text-sm text-gray-500">
                                Lleva el control de tus visitas y progreso en el gimnasio.
                            </p>
                        </div>
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-500 border border-gray-200">
                            Próximamente
                        </span>
                    </div>
                </div>

                {{-- Columna derecha: tarjetas de resumen / info de cuenta --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Info de cuenta tipo “card” --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="font-semibold text-gray-900">Información de tu cuenta</h4>
                                <p class="text-sm text-gray-500">
                                    Datos básicos registrados en el sistema.
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div class="space-y-1">
                                <p class="text-gray-500 font-semibold">Nombre completo</p>
                                <p class="text-gray-800">{{ $user->name }}</p>
                            </div>

                            <div class="space-y-1">
                                <p class="text-gray-500 font-semibold">Correo electrónico</p>
                                <p class="text-gray-800">{{ $user->email }}</p>
                            </div>

                            <div class="space-y-1">
                                <p class="text-gray-500 font-semibold">Rol en el sistema</p>
                                <p class="text-gray-800">
                                    {{ optional($user->role)->name ? ucfirst($user->role->name) : 'Sin rol asignado' }}
                                </p>
                            </div>

                            <div class="space-y-1">
                                <p class="text-gray-500 font-semibold">Estado de la cuenta</p>
                                <p class="text-gray-800">
                                    {{ $user->is_active ? 'Activa' : 'Inactiva' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Card dummy tipo “estadísticas” (relleno bonito para la ADA) --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="font-semibold text-gray-900">Resumen rápido</h4>
                                <p class="text-sm text-gray-500">
                                    Módulos que se activarán en futuras versiones.
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                            <div class="rounded-xl border border-gray-200 px-4 py-3">
                                <p class="text-gray-500 text-xs font-semibold uppercase">Membresía</p>
                                <p class="mt-1 text-gray-900 font-bold text-lg">—</p>
                                <p class="text-xs text-gray-400 mt-1">Aún no disponible.</p>
                            </div>

                            <div class="rounded-xl border border-gray-200 px-4 py-3">
                                <p class="text-gray-500 text-xs font-semibold uppercase">Visitas este mes</p>
                                <p class="mt-1 text-gray-900 font-bold text-lg">—</p>
                                <p class="text-xs text-gray-400 mt-1">Se mostrará tu asistencia.</p>
                            </div>

                            <div class="rounded-xl border border-gray-200 px-4 py-3">
                                <p class="text-gray-500 text-xs font-semibold uppercase">Último pago</p>
                                <p class="mt-1 text-gray-900 font-bold text-lg">—</p>
                                <p class="text-xs text-gray-400 mt-1">Se integrará el historial de pagos.</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
