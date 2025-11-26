<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Personal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Bienvenido, Personal del Gimnasio</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Ver Socios -->
                        <a href="{{ route('staff.members.index') }}" class="block p-6 bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:shadow-lg transition">
                            <div class="flex items-center">
                                <div class="text-4xl text-blue-600 mr-4">👥</div>
                                <div>
                                    <h4 class="font-bold text-lg text-blue-900">Ver Socios</h4>
                                    <p class="text-sm text-blue-700">Consulta la información de socios</p>
                                </div>
                            </div>
                        </a>

                        <!-- Registrar Entradas -->
                        <a href="{{ route('staff.attendance.index') }}" class="block p-6 bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg hover:shadow-lg transition">
                            <div class="flex items-center">
                                <div class="text-4xl text-green-600 mr-4">🚪</div>
                                <div>
                                    <h4 class="font-bold text-lg text-green-900">Registrar Entradas</h4>
                                    <p class="text-sm text-green-700">Registra entrada y salida de socios</p>
                                </div>
                            </div>
                        </a>

                        <!-- Registrar Pagos -->
                        <a href="{{ route('staff.payments.index') }}" class="block p-6 bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg hover:shadow-lg transition">
                            <div class="flex items-center">
                                <div class="text-4xl text-purple-600 mr-4">💳</div>
                                <div>
                                    <h4 class="font-bold text-lg text-purple-900">Registrar Pagos</h4>
                                    <p class="text-sm text-purple-700">Registra pagos de socios</p>
                                </div>
                            </div>
                        </a>

                        <!-- Administrar Clases -->
                        <a href="{{ route('staff.classes.index') }}" class="block p-6 bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-200 rounded-lg hover:shadow-lg transition">
                            <div class="flex items-center">
                                <div class="text-4xl text-yellow-600 mr-4">📚</div>
                                <div>
                                    <h4 class="font-bold text-lg text-yellow-900">Administrar Clases</h4>
                                    <p class="text-sm text-yellow-700">Consulta las clases disponibles</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-800">
                            <strong>Nota:</strong> Como personal del gimnasio, no tienes acceso para modificar roles ni gestionar usuarios del sistema.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
