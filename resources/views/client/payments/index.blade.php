<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Historial de Pagos') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Estadísticas --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-6">
                    <p class="text-sm text-blue-600 uppercase font-semibold tracking-wide">Este mes</p>
                    <p class="text-3xl font-bold text-blue-900 mt-2">${{ number_format($stats['total_this_month'], 2) }}</p>
                    <p class="text-xs text-blue-700 mt-1">Pagos completados</p>
                </div>

                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 rounded-lg p-6">
                    <p class="text-sm text-emerald-600 uppercase font-semibold tracking-wide">Total histórico</p>
                    <p class="text-3xl font-bold text-emerald-900 mt-2">${{ number_format($stats['total_all_time'], 2) }}</p>
                    <p class="text-xs text-emerald-700 mt-1">Todos los pagos</p>
                </div>
            </div>

            {{-- Historial de Pagos --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Historial de Transacciones</h3>
                </div>

                @if ($payments->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Fecha</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Concepto</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Método</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Monto</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($payments as $payment)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-gray-900 font-medium">
                                            {{ $payment->payment_date->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $payment->concept }}
                                            @if ($payment->membership)
                                                <span class="text-xs text-gray-500 block">{{ $payment->membership->plan_name }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">
                                            @switch($payment->payment_method)
                                                @case('cash')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Efectivo</span>
                                                    @break
                                                @case('card')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Tarjeta</span>
                                                    @break
                                                @case('transfer')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Transferencia</span>
                                                    @break
                                                @default
                                                    {{ ucfirst($payment->payment_method) }}
                                            @endswitch
                                        </td>
                                        <td class="px-6 py-4 text-gray-900 font-semibold">
                                            ${{ number_format($payment->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @switch($payment->status)
                                                @case('completed')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Completado</span>
                                                    @break
                                                @case('pending')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Pendiente</span>
                                                    @break
                                                @case('failed')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Fallido</span>
                                                    @break
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $payments->links() }}
                    </div>
                @else
                    <div class="px-6 py-10 text-center text-gray-500">
                        <p>No tienes pagos registrados.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
