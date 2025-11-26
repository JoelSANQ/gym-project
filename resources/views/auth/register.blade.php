<x-guest-layout class="bg-yellow-100 min-h-screen">
    <div class="w-full sm:max-w-2xl mt-6 px-6 py-4 bg-yellow-100 shadow-md overflow-hidden sm:rounded-lg">
        <div class="w-full max-w-md space-y-8">
            <!-- Logo/Title -->
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-bold text-gray-900">Registro</h2>
                <p class="mt-2 text-sm text-gray-600">Crear nueva cuenta</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="bg-white rounded-lg shadow-md p-8 space-y-4">
                @csrf

                <!-- Nombre de Usuario -->
                <div>
                    <x-input-label for="name" :value="__('Nombre de Usuario')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Tu nombre completo" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Rol -->
                <div class="mt-4">
                    <x-input-label for="role_id" :value="__('Rol')" />
                    <select id="role_id" name="role_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>
                        <option value="">-- Selecciona un rol --</option>
                        @php
                            $roles = \App\Models\Role::whereIn('name', ['staff', 'client'])->get();
                        @endphp
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="ejemplo@correo.com" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500" href="{{ route('login') }}">
                        {{ __('¿Ya estás registrado?') }}
                    </a>

                    <x-primary-button class="ms-4 bg-yellow-600 hover:bg-yellow-700">
                        {{ __('Registrarse') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
