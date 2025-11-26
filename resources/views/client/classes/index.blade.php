<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900 leading-tight">Tus Clases Inscritas</h2>
            <p class="text-sm text-gray-500">Clases a las que te has anotado o registrado (histórico de asistencia).</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($classes->count())
                        <div class="space-y-4">
                            @foreach($classes as $class)
                                <div class="border rounded-lg p-4 hover:shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $class->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $class->trainer?->name ?? 'Sin entrenador asignado' }}</p>
                                        </div>
                                        <div class="text-right text-sm text-gray-600">
                                            @if($class->is_active)
                                                <span class="px-2 py-1 rounded-full bg-emerald-50 text-emerald-700">Activa</span>
                                            @else
                                                <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-600">Inactiva</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if($class->schedules && $class->schedules->count())
                                        <div class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-2 text-sm text-gray-600">
                                            @foreach($class->schedules as $sched)
                                                <div class="px-3 py-2 bg-gray-50 rounded">
                                                    <strong class="block text-xs text-gray-500">{{ $sched->day_name }}</strong>
                                                    <span>{{ \Carbon\Carbon::parse($sched->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($sched->end_time)->format('H:i') }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="mt-3 text-sm text-gray-700">
                                        <p>Última asistencia: 
                                            @php
                                                $last = auth()->user()->attendance()->where('class_id', $class->id)->latest('check_in')->first();
                                            @endphp
                                            @if($last)
                                                {{ $last->check_in?->format('d/m/Y H:i') }}
                                            @else
                                                Nunca registrado
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-8 text-center text-gray-500">No te has anotado a ninguna clase todavía.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
