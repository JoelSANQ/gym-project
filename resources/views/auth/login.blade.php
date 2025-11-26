<x-guest-layout class="bg-yellow-100 min-h-screen">
    <div class="w-full sm:max-w-2xl mx-auto mt-6 px-6 py-4 bg-yellow-100 shadow-md overflow-hidden sm:rounded-lg">
        <div class="w-full max-w-lg space-y-8">
            <!-- Logo/Title -->
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-bold text-gray-900">Gimnasio</h2>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="bg-white rounded-lg shadow-md p-8 space-y-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full"
                                    type="email"
                                    name="email"
                                    :value="old('email')"
                                    required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-yellow-600 shadow-sm focus:ring-yellow-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Recuérdame') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500" href="{{ route('password.request') }}">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3 bg-yellow-600 hover:bg-yellow-700">
                        {{ __('Iniciar sesión') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Registro -->
            <div class="text-center">
                <p class="text-sm text-gray-700">
                    ¿No tienes una cuenta?
                    <a href="{{ route('register') }}" class="font-semibold text-yellow-600 hover:text-yellow-700 underline">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
