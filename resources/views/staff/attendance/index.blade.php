<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Entrada al Gimnasio') }}
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
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Nueva Entrada</h3>
                    
                    <form method="POST" action="{{ route('staff.attendance.store') }}">
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
                                <x-input-label for="class_id" value="Clase" />
                                <select id="class_id" name="class_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">-- Selecciona una clase --</option>
                                    @foreach ($classes as $class)
                                        @php
                                            $dayNames = $class->schedules->pluck('day_name')->join(', ');
                                        @endphp
                                        <option value="{{ $class->id }}" data-schedules="{{ json_encode($class->schedules->pluck('day_of_week')) }}">
                                            {{ $class->name }} ({{ $dayNames }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('class_id')" class="mt-1" />
                            </div>

                            <div>
                                <x-input-label for="date" value="Fecha" />
                                <x-text-input id="date" name="date" type="date" 
                                    class="mt-1 block w-full" required />
                                <small class="text-gray-500 text-xs mt-1">Solo puedes seleccionar días disponibles para la clase</small>
                                <x-input-error :messages="$errors->get('date')" class="mt-1" />
                            </div>

                            <div>
                                <x-input-label for="check_in" value="Bloque Horario" />
                                <select id="check_in" name="check_in"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">-- Selecciona un bloque --</option>
                                    <option value="06:00">6:00 - 7:00 AM</option>
                                    <option value="07:00">7:00 - 8:00 AM</option>
                                    <option value="08:00">8:00 - 9:00 AM</option>
                                    <option value="17:00">5:00 - 6:00 PM</option>
                                    <option value="18:00">6:00 - 7:00 PM</option>
                                    <option value="19:00">7:00 - 8:00 PM</option>
                                    <option value="20:00">8:00 - 9:00 PM</option>
                                </select>
                                <x-input-error :messages="$errors->get('check_in')" class="mt-1" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('staff.attendance.index') }}"
                               class="text-sm text-gray-600 hover:text-gray-900">
                                Cancelar
                            </a>

                            <x-primary-button>
                                Registrar Entrada
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                {{-- Panel lateral de información --}}
                <div class="space-y-4">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm font-semibold text-blue-900 mb-2">💡 Instrucciones</p>
                        <ul class="text-xs text-blue-800 space-y-1">
                            <li>1. Selecciona el socio que entra</li>
                            <li>2. Selecciona la clase a la que asiste</li>
                            <li>3. Selecciona un día disponible para esa clase</li>
                            <li>4. Selecciona el bloque horario</li>
                            <li>5. Haz clic en Registrar</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Historial de entradas recientes --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Entradas Recientes</h3>
                </div>

                <div class="px-6 py-4 overflow-x-auto">
                    @php
                        $recentAttendance = \App\Models\Attendance::with('user', 'class')
                            ->latest('check_in')
                            ->limit(10)
                            ->get();
                    @endphp

                    @if ($recentAttendance->count())
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Socio</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Clase</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Entrada</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Salida</th>
                                    <th class="px-3 py-2 text-right font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($recentAttendance as $attendance)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 font-medium text-gray-900">
                                            {{ $attendance->user->name }}
                                        </td>
                                        <td class="px-3 py-2 text-gray-700">
                                            {{ $attendance->class->name }}
                                        </td>
                                        <td class="px-3 py-2 text-gray-700">
                                            {{ $attendance->check_in->format('H:i') }}
                                        </td>
                                        <td class="px-3 py-2 text-gray-700">
                                            @if ($attendance->check_out)
                                                {{ $attendance->check_out->format('H:i') }}
                                            @else
                                                <span class="text-amber-600 font-semibold">En clase</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-2 text-right">
                                            @if (!$attendance->check_out)
                                                <form action="{{ route('staff.attendance.checkOut', $attendance) }}"
                                                      method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="text-emerald-600 hover:text-emerald-800 text-xs font-medium">
                                                        Registrar Salida
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        const classSelect = document.getElementById('class_id');
        const dateInput = document.getElementById('date');

        classSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const schedulesJson = selectedOption.getAttribute('data-schedules');
            
            if (!schedulesJson) {
                dateInput.removeAttribute('data-allowed-days');
                return;
            }

            const allowedDays = JSON.parse(schedulesJson);
            dateInput.setAttribute('data-allowed-days', JSON.stringify(allowedDays));
            dateInput.value = '';
        });

        // Validar que el día seleccionado sea válido para la clase
        dateInput.addEventListener('change', function() {
            const classId = classSelect.value;
            if (!classId) {
                alert('Por favor selecciona una clase primero');
                this.value = '';
                return;
            }

            const selectedDate = new Date(this.value);
            const dayOfWeek = selectedDate.getDay(); // 0=Domingo, 1=Lunes, etc
            
            const allowedDaysJson = this.getAttribute('data-allowed-days');
            if (!allowedDaysJson) return;

            const allowedDays = JSON.parse(allowedDaysJson);
            
            if (!allowedDays.includes(dayOfWeek)) {
                alert('Esta clase no se imparte en ese día. Por favor selecciona otro día.');
                this.value = '';
            }
        });
    </script>
</x-app-layout>
