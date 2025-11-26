<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Clases Disponibles') }}
            </h2>

            <span class="text-sm text-gray-500">
                Total: {{ $classes->total() }} clase(s)
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Card principal --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Listado de Clases Activas</h3>
                        <p class="text-sm text-gray-500">
                            Consulta las clases disponibles en el gimnasio.
                        </p>
                    </div>
                </div>

                {{-- Tabla --}}
                <div class="px-6 py-4 overflow-x-auto">
                    @if ($classes->count())
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Horario</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Entrenador</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Capacidad</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($classes as $class)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 font-semibold text-gray-900">
                                            {{ $class->name }}
                                        </td>

                                        <td class="px-3 py-2 text-gray-700">
                                            {{ $class->schedule }}
                                        </td>

                                        <td class="px-3 py-2 text-gray-700">
                                            @if ($class->trainer)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                                    {{ $class->trainer->name }}
                                                </span>
                                            @else
                                                <span class="text-gray-500 text-xs">Por asignar</span>
                                            @endif
                                        </td>

                                        <td class="px-3 py-2 text-gray-700">
                                            {{ $class->capacity }} personas
                                        </td>

                                        <td class="px-3 py-2 text-gray-700 max-w-xs truncate">
                                            {{ $class->description ?? 'Sin descripción' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="py-10 text-center text-sm text-gray-500">
                            No hay clases activas disponibles.
                        </div>
                    @endif
                </div>

                {{-- Paginación --}}
                <div class="px-6 py-3 border-t border-gray-100">
                    {{ $classes->links() }}
                </div>
            </div>

            {{-- Info importante --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <p class="text-2xl">ℹ️</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-blue-900">Información</h3>
                        <p class="text-sm text-blue-800 mt-1">
                            Como personal del gimnasio, puedes consultar las clases disponibles. Para crear, editar o eliminar clases, contacta con administración.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
