<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Pagos') }}
            </h2>
            <a href="{{ route('admin.payments.create') }}"
               class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 text-sm font-medium">
                + Nuevo Pago
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
                    @if ($payments->count())
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Cliente</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Concepto</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Monto</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Método</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Estado</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Fecha</th>
                                        <th class="px-4 py-3 text-right font-semibold text-gray-700">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach ($payments as $payment)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $payment->user->name }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700">
                                                {{ $payment->concept }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 font-semibold">
                                                ${{ number_format($payment->amount, 2) }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700">
                                                @php
                                                    $methods = ['cash' => 'Efectivo', 'card' => 'Tarjeta', 'transfer' => 'Transferencia', 'check' => 'Cheque'];
                                                @endphp
                                                {{ $methods[$payment->payment_method] ?? $payment->payment_method }}
                                            </td>
                                            <td class="px-4 py-3">
                                                @if ($payment->status === 'completed')
                                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-semibold">Completado</span>
                                                @elseif ($payment->status === 'pending')
                                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Pendiente</span>
                                                @else
                                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Fallido</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-gray-700">
                                                {{ $payment->payment_date->format('d/m/Y') }}
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <a href="{{ route('admin.payments.edit', $payment) }}"
                                                   class="text-blue-600 hover:text-blue-800 font-medium text-sm mr-3">
                                                    Editar
                                                </a>
                                                <form action="{{ route('admin.payments.destroy', $payment) }}"
                                                      method="POST" class="inline"
                                                      onsubmit="return confirm('¿Eliminar pago?')">
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
                            {{ $payments->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No hay pagos registrados.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
