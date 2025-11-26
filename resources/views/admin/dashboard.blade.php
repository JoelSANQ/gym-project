<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Administración') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Bienvenido, Administrador</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Gestión de Usuarios -->
                        <a href="{{ route('admin.users.index') }}" class="block p-6 bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:shadow-lg transition">
                            <div class="flex items-center">
                                <div class="text-4xl text-blue-600 mr-4">👥</div>
                                <div>
                                    <h4 class="font-bold text-lg text-blue-900">Gestión de Usuarios</h4>
                                    <p class="text-sm text-blue-700">Crear, editar y eliminar usuarios</p>
                                </div>
                            </div>
                        </a>

                        <!-- Gestión de Clases -->
                        <a href="{{ route('admin.classes.index') }}" class="block p-6 bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg hover:shadow-lg transition">
                            <div class="flex items-center">
                                <div class="text-4xl text-green-600 mr-4">📚</div>
                                <div>
                                    <h4 class="font-bold text-lg text-green-900">Gestión de Clases</h4>
                                    <p class="text-sm text-green-700">Crear, editar y gestionar clases</p>
                                </div>
                            </div>
                        </a>

                        <!-- Gestión de Membresías -->
                        <a href="{{ route('admin.memberships.index') }}" class="block p-6 bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg hover:shadow-lg transition">
                            <div class="flex items-center">
                                <div class="text-4xl text-purple-600 mr-4">🎫</div>
                                <div>
                                    <h4 class="font-bold text-lg text-purple-900">Gestión de Membresías</h4>
                                    <p class="text-sm text-purple-700">Crear, editar y gestionar membresías</p>
                                </div>
                            </div>
                        </a>

                        <!-- Gestión de Pagos -->
                        <a href="{{ route('admin.payments.index') }}" class="block p-6 bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-200 rounded-lg hover:shadow-lg transition">
                            <div class="flex items-center">
                                <div class="text-4xl text-yellow-600 mr-4">💳</div>
                                <div>
                                    <h4 class="font-bold text-lg text-yellow-900">Gestión de Pagos</h4>
                                    <p class="text-sm text-yellow-700">Registrar y gestionar pagos</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
