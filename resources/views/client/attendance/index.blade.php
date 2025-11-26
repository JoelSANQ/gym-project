<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Asistencia') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Estadísticas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-6">
                    <p class="text-sm text-blue-600 uppercase font-semibold tracking-wide">Este mes</p>
                    <p class="text-4xl font-bold text-blue-900 mt-2">{{ $monthlyStats['current_month'] }}</p>
                    <p class="text-xs text-blue-700 mt-1">{{ $monthlyStats['month_name'] }}</p>
                </div>

                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 rounded-lg p-6">
                    <p class="text-sm text-emerald-600 uppercase font-semibold tracking-wide">Total visitas</p>
                    <p class="text-4xl font-bold text-emerald-900 mt-2">{{ auth()->user()->attendance()->count() }}</p>
                    <p class="text-xs text-emerald-700 mt-1">histórico</p>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg p-6">
                    <p class="text-sm text-purple-600 uppercase font-semibold tracking-wide">Promedio</p>
                    <p class="text-4xl font-bold text-purple-900 mt-2">
                        {{ auth()->user()->attendance()->count() > 0 ? round(auth()->user()->attendance()->count() / max(1, now()->month)) : 0 }}
                    </p>
                    <p class="text-xs text-purple-700 mt-1">visitas/mes</p>
                </div>
            </div>

            {{-- Historial de Asistencia --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Historial de Entradas</h3>
                </div>

                @if ($attendance->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Fecha</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Hora</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Clase</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Duración</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($attendance as $record)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-gray-900 font-medium">
                                            {{ $record->check_in->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $record->check_in->format('H:i') }}
                                            @if ($record->check_out)
                                                - {{ $record->check_out->format('H:i') }}
                                            @else
                                                <span class="text-amber-600 font-semibold">en curso</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $record->class->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">
                                            @if ($record->check_out)
                                                {{ $record->check_in->diffInMinutes($record->check_out) }} min
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $attendance->links() }}
                    </div>
                @else
                    <div class="px-6 py-10 text-center text-gray-500">
                        <p>Aún no tienes registros de asistencia.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
