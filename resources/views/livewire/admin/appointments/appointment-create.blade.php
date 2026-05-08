<div>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Buscar Disponibilidad -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-800">Buscar disponibilidad</h2>
                    <p class="text-sm text-gray-500">Encuentra el horario perfecto para tu cita.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Fecha</label>
                        <input type="date" wire:model.live="date" class="w-full border-gray-100 bg-gray-50/50 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Hora</label>
                        <select wire:model.live="time_range" class="w-full border-gray-100 bg-gray-50/50 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Seleccionar hora</option>
                            <option value="08">08:00 AM</option>
                            <option value="09">09:00 AM</option>
                            <option value="10">10:00 AM</option>
                            <option value="11">11:00 AM</option>
                            <option value="12">12:00 PM</option>
                            <option value="13">01:00 PM</option>
                            <option value="14">02:00 PM</option>
                            <option value="15">03:00 PM</option>
                            <option value="16">04:00 PM</option>
                            <option value="17">05:00 PM</option>
                            <option value="18">06:00 PM</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Especialidad (Opcional)</label>
                        <select wire:model.live="specialty" class="w-full border-gray-100 bg-gray-50/50 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Seleccionar especialidad</option>
                            @foreach($specialties as $spec)
                                <option value="{{ $spec }}">{{ $spec }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button wire:click="searchAvailability" class="w-full py-2 bg-indigo-600 text-white rounded-md font-semibold text-sm hover:bg-indigo-700 transition-all shadow-sm">
                            Buscar disponibilidad
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Results -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Results Section -->
                    @if($showResults)
                        <div class="space-y-4">
                            @forelse($searchResults as $doctor)
                                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex items-start space-x-6">
                                    <div class="w-14 h-14 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-500 font-bold text-lg uppercase">
                                        @php
                                            $parts = explode(' ', $doctor->user->name);
                                            $surname = end($parts);
                                            $initial = substr($surname, 0, 1);
                                        @endphp
                                        D{{ $initial }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="pb-4 border-b border-gray-100 mb-4">
                                            <h3 class="text-lg font-bold text-gray-800">{{ $doctor->user->name }}</h3>
                                            <p class="text-xs text-indigo-600 font-medium">{{ $doctor->specialty }}</p>
                                        </div>

                                        <div class="space-y-3">
                                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Horarios disponibles:</p>
                                            <div class="flex flex-wrap gap-2">
                                                @php
                                                    $slots = $doctor->schedules->where('day_of_week', $dayOfWeek);
                                                    if ($time_range) {
                                                        $slots = $slots->filter(fn($s) => str_starts_with($s->start_time, $time_range));
                                                    }
                                                    $bookedTimes = \App\Models\Appointment::where('doctor_id', $doctor->id)->where('date', $date)->pluck('start_time')->map(fn($t) => date('H:i:s', strtotime($t)))->toArray();
                                                @endphp
                                                @forelse($slots->sortBy('start_time') as $slot)
                                                    @if(!in_array($slot->start_time, $bookedTimes))
                                                        <button wire:click="selectSlot({{ $doctor->id }}, '{{ $slot->start_time }}')" 
                                                            class="px-5 py-2 rounded-md text-xs font-bold transition-all {{ ($doctor_id == $doctor->id && $start_time == $slot->start_time) ? 'bg-indigo-600 text-white ring-2 ring-indigo-200' : 'bg-indigo-100 text-indigo-700 hover:bg-indigo-200 border border-indigo-200' }}">
                                                            {{ date('H:i', strtotime($slot->start_time)) }}
                                                        </button>
                                                    @endif
                                                @empty
                                                    <p class="text-xs text-gray-400 italic">No hay horarios disponibles.</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-white p-12 rounded-lg shadow-sm border border-gray-100 text-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <h3 class="text-gray-800 font-bold">No se encontraron doctores</h3>
                                    <p class="text-sm text-gray-500">Prueba cambiando la fecha o la especialidad.</p>
                                </div>
                            @endforelse
                        </div>
                    @else
                        <div class="bg-indigo-50/50 p-12 rounded-lg border border-indigo-100/50 text-center">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <h3 class="text-indigo-900 font-bold">Inicia una búsqueda</h3>
                            <p class="text-sm text-indigo-600/70">Selecciona los criterios arriba para ver opciones.</p>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Summary -->
                <div class="space-y-6">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                        <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100">
                            <h2 class="text-lg font-bold text-gray-800">Resumen de la cita</h2>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500">Doctor:</span>
                                    <div class="w-2/3">
                                        <select wire:model="doctor_id" class="w-full border-none p-0 text-right font-medium text-gray-800 focus:ring-0 bg-transparent text-sm">
                                            <option value="">-</option>
                                            @foreach($doctors as $doc)
                                                <option value="{{ $doc->id }}">{{ $doc->user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500">Fecha:</span>
                                    <div class="w-2/3 flex justify-end">
                                        <input type="date" wire:model="date" class="border-none p-0 text-right font-medium text-gray-800 focus:ring-0 bg-transparent text-sm">
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500">Horario:</span>
                                    <div class="flex items-center space-x-1 justify-end w-2/3">
                                        <input type="time" wire:model="start_time" class="w-32 border-none p-0 font-medium text-gray-800 focus:ring-0 bg-transparent text-sm">
                                        <span class="text-gray-400">-</span>
                                        <input type="time" wire:model="end_time" class="w-32 border-none p-0 font-medium text-gray-800 focus:ring-0 bg-transparent text-sm">
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500">Duración:</span>
                                    <span class="font-medium text-gray-800 text-sm">{{ $duration }} minutos</span>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-100 space-y-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Paciente</label>
                                    <select wire:model="patient_id" class="w-full border-gray-100 bg-gray-50/50 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Seleccionar paciente</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('patient_id') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Motivo de la cita</label>
                                    <textarea wire:model="reason" rows="3" class="w-full border-gray-100 bg-gray-50/50 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Escribe el motivo..."></textarea>
                                    @error('reason') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <button wire:click="save" class="w-full py-3 bg-indigo-600 text-white rounded-md font-bold text-sm hover:bg-indigo-700 transition-all shadow-md shadow-indigo-100">
                                Confirmar cita
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
