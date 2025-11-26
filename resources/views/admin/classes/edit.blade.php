<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar clase') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.classes.update', $class) }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <x-input-label for="name" value="Nombre de la clase" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                value="{{ old('name', $class->name) }}" placeholder="Ej: Yoga, Crossfit, Spinning..." required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="description" value="Descripción" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                                placeholder="Describe la clase...">{{ old('description', $class->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-1" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="capacity" value="Capacidad (personas)" />
                                <x-text-input id="capacity" name="capacity" type="number" class="mt-1 block w-full"
                                    value="{{ old('capacity', $class->capacity) }}" min="1" required />
                                <x-input-error :messages="$errors->get('capacity')" class="mt-1" />
                            </div>

                            <div>
                                <x-input-label for="schedule" value="Horario" />
                                <x-text-input id="schedule" name="schedule" type="text" class="mt-1 block w-full"
                                    value="{{ old('schedule', $class->schedule) }}" placeholder="Ej: Lunes 10:00 - 11:00" required />
                                <x-input-error :messages="$errors->get('schedule')" class="mt-1" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="trainer_id" value="Entrenador" />
                            <select id="trainer_id" name="trainer_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Selecciona un entrenador --</option>
                                @foreach ($trainers as $trainer)
                                    <option value="{{ $trainer->id }}" @selected(old('trainer_id', $class->trainer_id) == $trainer->id)>
                                        {{ $trainer->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('trainer_id')" class="mt-1" />
                        </div>

                        <div class="flex items-center">
                            <input id="is_active" name="is_active" type="checkbox" value="1"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm"
                                {{ old('is_active', $class->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="ms-2 text-sm text-gray-600">
                                Clase activa
                            </label>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.classes.index') }}"
                           class="text-sm text-gray-600 hover:text-gray-900">
                            Cancelar
                        </a>

                        <x-primary-button>
                            Guardar cambios
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
