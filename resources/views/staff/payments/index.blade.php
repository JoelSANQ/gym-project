<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Pagos') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Alertas --}}
            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-md text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Formulario de Registro --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Nuevo Pago</h3>
                    
                    <form method="POST" action="{{ route('staff.payments.store') }}">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <x-input-label for="user_id" value="Socio" />
                                <select id="user_id" name="user_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">-- Selecciona un socio --</option>
                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}">
                                            {{ $member->name }} ({{ $member->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('user_id')" class="mt-1" />
                            </div>

                            <div>
                                <x-input-label for="concept" value="Concepto" />
                                <x-text-input id="concept" name="concept" type="text" 
                                    class="mt-1 block w-full" placeholder="Ej: Membresía Mensual"
                                    required />
                                <x-input-error :messages="$errors->get('concept')" class="mt-1" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="amount" value="Monto" />
                                    <x-text-input id="amount" name="amount" type="number" step="0.01"
                                        class="mt-1 block w-full" placeholder="0.00" required />
                                    <x-input-error :messages="$errors->get('amount')" class="mt-1" />
                                </div>

                                <div>
                                    <x-input-label for="payment_method" value="Método de Pago" />
                                    <select id="payment_method" name="payment_method"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                        <option value="">-- Selecciona método --</option>
                                        <option value="cash">Efectivo</option>
                                        <option value="card">Tarjeta</option>
                                        <option value="transfer">Transferencia</option>
                                        <option value="check">Cheque</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('payment_method')" class="mt-1" />
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="payment_date" value="Fecha de Pago" />
                                    <x-text-input id="payment_date" name="payment_date" type="date"
                                        class="mt-1 block w-full" value="{{ now()->format('Y-m-d') }}" required />
                                    <x-input-error :messages="$errors->get('payment_date')" class="mt-1" />
                                </div>

                                <div>
                                    <x-input-label for="status" value="Estado" />
                                    <select id="status" name="status"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                        <option value="completed">Completado</option>
                                        <option value="pending">Pendiente</option>
                                        <option value="failed">Fallido</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" class="mt-1" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="notes" value="Notas (Opcional)" />
                                <textarea id="notes" name="notes" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    rows="3" placeholder="Notas adicionales..."></textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-1" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('staff.payments.index') }}"
                               class="text-sm text-gray-600 hover:text-gray-900">
                                Cancelar
                            </a>

                            <x-primary-button>
                                Registrar Pago
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                {{-- Panel lateral --}}
                <div class="space-y-4">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <p class="text-sm font-semibold text-green-900 mb-2">✅ Métodos de Pago</p>
                        <ul class="text-xs text-green-800 space-y-1">
                            <li>💵 Efectivo</li>
                            <li>💳 Tarjeta (crédito/débito)</li>
                            <li>🏦 Transferencia bancaria</li>
                            <li>✏️ Cheque</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Historial de pagos --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Historial de Pagos</h3>
                </div>

                <div class="px-6 py-4 overflow-x-auto">
                    @if ($payments->count())
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Socio</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Concepto</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Monto</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Método</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Fecha</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($payments as $payment)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 font-medium text-gray-900">
                                            {{ $payment->user->name }}
                                        </td>
                                        <td class="px-3 py-2 text-gray-700">
                                            {{ $payment->concept }}
                                        </td>
                                        <td class="px-3 py-2 font-semibold text-gray-900">
                                            ${{ number_format($payment->amount, 2) }}
                                        </td>
                                        <td class="px-3 py-2 text-gray-700">
                                            @switch($payment->payment_method)
                                                @case('cash')
                                                    <span class="text-xs font-semibold text-green-700">💵 Efectivo</span>
                                                    @break
                                                @case('card')
                                                    <span class="text-xs font-semibold text-blue-700">💳 Tarjeta</span>
                                                    @break
                                                @case('transfer')
                                                    <span class="text-xs font-semibold text-purple-700">🏦 Transferencia</span>
                                                    @break
                                                @case('check')
                                                    <span class="text-xs font-semibold text-orange-700">✏️ Cheque</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td class="px-3 py-2 text-gray-700">
                                            {{ $payment->payment_date->format('d/m/Y') }}
                                        </td>
                                        <td class="px-3 py-2">
                                            @switch($payment->status)
                                                @case('completed')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                                        Completado
                                                    </span>
                                                    @break
                                                @case('pending')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                                        Pendiente
                                                    </span>
                                                    @break
                                                @case('failed')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Fallido
                                                    </span>
                                                    @break
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <div class="px-6 py-3 border-t border-gray-100">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
