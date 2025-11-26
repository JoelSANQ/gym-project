<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Membresía') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.memberships.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="user_id" value="Cliente" />
                        <select id="user_id" name="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">-- Selecciona un cliente --</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" @selected(old('user_id') == $client->id)>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('user_id')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="plan_name" value="Nombre del Plan" />
                        <x-text-input id="plan_name" name="plan_name" type="text" placeholder="Ej: Premium" 
                            value="{{ old('plan_name') }}" required />
                        <x-input-error :messages="$errors->get('plan_name')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="price" value="Precio" />
                        <x-text-input id="price" name="price" type="number" step="0.01" placeholder="0.00"
                            value="{{ old('price') }}" required />
                        <x-input-error :messages="$errors->get('price')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Descripción" />
                        <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            placeholder="Detalles del plan">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="start_date" value="Fecha Inicio" />
                            <x-text-input id="start_date" name="start_date" type="date" 
                                value="{{ old('start_date') }}" required />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="end_date" value="Fecha Fin" />
                            <x-text-input id="end_date" name="end_date" type="date" 
                                value="{{ old('end_date') }}" required />
                            <x-input-error :messages="$errors->get('end_date')" class="mt-1" />
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" @checked(old('is_active'))
                                class="rounded border-gray-300 text-emerald-600 shadow-sm" />
                            <span class="ml-2 text-sm text-gray-700">Membresía Activa</span>
                        </label>
                    </div>

                    <div class="flex justify-between pt-4">
                        <a href="{{ route('admin.memberships.index') }}" class="text-gray-600 hover:text-gray-900">
                            Cancelar
                        </a>
                        <x-primary-button>
                            Crear Membresía
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
