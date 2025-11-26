<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Pago') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.payments.update', $payment) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="user_id" value="Cliente" />
                        <select id="user_id" name="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">-- Selecciona un cliente --</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" @selected($payment->user_id == $client->id)>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('user_id')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="membership_id" value="Membresía (Opcional)" />
                        <select id="membership_id" name="membership_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Ninguna --</option>
                            @foreach ($memberships as $membership)
                                <option value="{{ $membership->id }}" @selected($payment->membership_id == $membership->id)>
                                    {{ $membership->user->name }} - {{ $membership->plan_name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('membership_id')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="concept" value="Concepto" />
                        <x-text-input id="concept" name="concept" type="text" placeholder="Ej: Membresía Premium"
                            value="{{ old('concept', $payment->concept) }}" required />
                        <x-input-error :messages="$errors->get('concept')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="amount" value="Monto" />
                        <x-text-input id="amount" name="amount" type="number" step="0.01" placeholder="0.00"
                            value="{{ old('amount', $payment->amount) }}" required />
                        <x-input-error :messages="$errors->get('amount')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="payment_method" value="Método de Pago" />
                        <select id="payment_method" name="payment_method" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">-- Selecciona --</option>
                            <option value="cash" @selected($payment->payment_method == 'cash')>Efectivo</option>
                            <option value="card" @selected($payment->payment_method == 'card')>Tarjeta</option>
                            <option value="transfer" @selected($payment->payment_method == 'transfer')>Transferencia</option>
                            <option value="check" @selected($payment->payment_method == 'check')>Cheque</option>
                        </select>
                        <x-input-error :messages="$errors->get('payment_method')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="status" value="Estado" />
                        <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">-- Selecciona --</option>
                            <option value="completed" @selected($payment->status == 'completed')>Completado</option>
                            <option value="pending" @selected($payment->status == 'pending')>Pendiente</option>
                            <option value="failed" @selected($payment->status == 'failed')>Fallido</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="payment_date" value="Fecha de Pago" />
                        <x-text-input id="payment_date" name="payment_date" type="date" 
                            value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}" required />
                        <x-input-error :messages="$errors->get('payment_date')" class="mt-1" />
                    </div>

                    <div class="flex justify-between pt-4">
                        <a href="{{ route('admin.payments.index') }}" class="text-gray-600 hover:text-gray-900">
                            Cancelar
                        </a>
                        <x-primary-button>
                            Actualizar Pago
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
