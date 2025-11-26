<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Clases') }}
            </h2>

            <span class="text-sm text-gray-500">
                Total: {{ $classes->total() }} clase(s)
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Alertas --}}
            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-md text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Card principal --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Listado de clases</h3>
                        <p class="text-sm text-gray-500">
                            Administra todas las clases disponibles en el gimnasio.
                        </p>
                    </div>

                    <a href="{{ route('admin.classes.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        + Nueva clase
                    </a>
                </div>

                {{-- Tabla --}}
                <div class="px-6 py-4 overflow-x-auto">
                    @if ($classes->count())
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Horario</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Entrenador</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Capacidad</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-3 py-2 text-right font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($classes as $class)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 text-gray-700">
                                            #{{ $class->id }}
                                        </td>

                                        <td class="px-3 py-2">
                                            <div class="flex flex-col">
                                                <span class="text-gray-900 font-medium">
                                                    {{ $class->name }}
                                                </span>
                                                <span class="text-xs text-gray-400">
                                                    {{ $class->created_at?->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="px-3 py-2 text-gray-700">
                                            {{ $class->schedule }}
                                        </td>

                                        <td class="px-3 py-2 text-gray-700">
                                            @if ($class->trainer)
                                                {{ $class->trainer->name }}
                                            @else
                                                <span class="text-gray-400">Sin asignar</span>
                                            @endif
                                        </td>

                                        <td class="px-3 py-2 text-gray-700">
                                            {{ $class->capacity }} personas
                                        </td>

                                        <td class="px-3 py-2">
                                            @if ($class->is_active)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    Activa
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                                    Inactiva
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-3 py-2 text-right space-x-2">
                                            {{-- Editar --}}
                                            <a href="{{ route('admin.classes.edit', $class) }}"
                                               class="text-indigo-600 hover:text-indigo-800 text-xs font-medium">
                                                Editar
                                            </a>

                                            @if($class->is_active)
                                                {{-- Desactivar --}}
                                                                                                <form action="{{ route('admin.classes.destroy', $class) }}"
                                                                                                            method="POST" class="inline swal-form" data-title="Desactivar clase" data-text="¿Desactivar esta clase?">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                                                                                onclick="return confirm('¿Desactivar esta clase?')"
                                                        class="text-red-600 hover:text-red-800 text-xs font-medium">
                                                        Desactivar
                                                    </button>
                                                </form>
                                            @else
                                                {{-- Reactivar --}}
                                                                                                <form action="{{ route('admin.classes.activate', $class) }}"
                                                                                                            method="POST" class="inline swal-form" data-title="Reactivar clase" data-text="¿Reactivar esta clase?">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                                                                                onclick="return confirm('¿Reactivar esta clase?')"
                                                        class="text-emerald-600 hover:text-emerald-800 text-xs font-medium">
                                                        Reactivar
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="py-10 text-center text-sm text-gray-500">
                            No hay clases registradas aún.
                        </div>
                    @endif
                </div>

                {{-- Paginación --}}
                <div class="px-6 py-3 border-t border-gray-100">
                    {{ $classes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
