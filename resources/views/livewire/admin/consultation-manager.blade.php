<div>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Patient Header Section -->
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $appointment->patient->user->name }}</h1>
                    <p class="text-sm text-gray-500 font-medium">DNI: {{ $appointment->patient->user->id_number }}</p>
                </div>
                <div class="flex space-x-3">
                    <button wire:click="$set('showMedicalHistoryModal', true)" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Ver Historia
                    </button>
                    <button wire:click="$set('showHistoryModal', true)" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Consultas Anteriores
                    </button>
                </div>
            </div>

            <!-- Main Consultation Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <!-- Tabs -->
                <div class="border-b border-gray-100 bg-gray-50/50">
                    <nav class="flex space-x-8 px-6" aria-label="Tabs">
                        <button wire:click="$set('activeTab', 'consulta')" class="{{ $activeTab === 'consulta' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Consulta
                        </button>
                        <button wire:click="$set('activeTab', 'receta')" class="{{ $activeTab === 'receta' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Receta
                        </button>
                    </nav>
                </div>

                <div class="p-6">
                    @if($activeTab === 'consulta')
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Diagnóstico</label>
                                <textarea wire:model="diagnosis" rows="5" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm placeholder:text-gray-400/70" placeholder="Describa el diagnóstico del paciente aquí..."></textarea>
                                @error('diagnosis') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tratamiento</label>
                                <textarea wire:model="treatment" rows="5" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm placeholder:text-gray-400/70" placeholder="Describa el tratamiento recomendado aquí..."></textarea>
                                @error('treatment') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Notas</label>
                                <textarea wire:model="notes" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm placeholder:text-gray-400/70" placeholder="Agregue notas adicionales sobre la consulta..."></textarea>
                            </div>
                        </div>
                    @else
                        <!-- Prescription Tab Content -->
                        <div class="space-y-6">
                            <div class="bg-gray-50/30 p-6 rounded-lg border border-gray-100 space-y-4">
                                @foreach($medications as $index => $med)
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                                        <div class="md:col-span-5">
                                            <label class="block text-xs font-semibold text-gray-500 mb-1">Medicamento</label>
                                            <input type="text" wire:model="medications.{{ $index }}.name" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm placeholder:text-gray-400/70" placeholder="Amoxicilina 500mg">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-semibold text-gray-500 mb-1">Dosis</label>
                                            <input type="text" wire:model="medications.{{ $index }}.dose" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm placeholder:text-gray-400/70" placeholder="1 cada 8 horas">
                                        </div>
                                        <div class="md:col-span-4">
                                            <label class="block text-xs font-semibold text-gray-500 mb-1">Frecuencia / Duración</label>
                                            <input type="text" wire:model="medications.{{ $index }}.frequency" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm placeholder:text-gray-400/70" placeholder="Ej: cada 8 horas por 7 días">
                                        </div>
                                        <div class="md:col-span-1">
                                            <button type="button" wire:click="removeMedication({{ $index }})" class="w-full text-white bg-red-500 p-2 rounded-md hover:bg-red-600 transition shadow-sm flex justify-center">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="pt-2">
                                    <button type="button" wire:click="addMedication" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        Añadir Medicamento
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mt-8 flex justify-end">
                        <button wire:click="saveConsultation" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 transition shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 002-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Guardar Consulta
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical History Modal (New Design) -->
    @if($showMedicalHistoryModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="$set('showMedicalHistoryModal', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-bold text-gray-800">Historia médica del paciente</h3>
                        <button wire:click="$set('showMedicalHistoryModal', false)" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="px-6 py-8">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 mb-2">Tipo de sangre:</p>
                                <p class="text-sm font-bold text-gray-800">{{ $appointment->patient->bloodType?->name ?? 'No registrado' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 mb-2">Alergias:</p>
                                <p class="text-sm font-bold text-gray-800">{{ $appointment->patient->allergies ?? 'No registradas' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 mb-2">Enfermedades crónicas:</p>
                                <p class="text-sm font-bold text-gray-800">{{ $appointment->patient->chronic_conditions ?? 'No registradas' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 mb-2">Antecedentes quirúrgicos:</p>
                                <p class="text-sm font-bold text-gray-800">{{ $appointment->patient->surgical_history ?? 'No registradas' }}</p>
                            </div>
                        </div>

                        <!-- Modal Footer Link -->
                        <div class="mt-10 flex justify-end">
                            <a href="{{ route('admin.patients.edit', $appointment->patient) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                                Ver / Editar Historia Médica
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Previous Consultations Modal -->
    @if($showHistoryModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="$set('showHistoryModal', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-bold text-gray-800">Consultas Anteriores</h3>
                        <button wire:click="$set('showHistoryModal', false)" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="px-6 py-6 bg-gray-50/30 max-h-[70vh] overflow-y-auto space-y-4">
                        @forelse($pastAppointments as $past)
                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 space-y-4">
                                <div class="flex justify-between items-start">
                                    <div class="space-y-1">
                                        <div class="flex items-center text-indigo-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <span class="text-sm font-bold">{{ $past->date->format('d/m/Y') }} a las {{ date('H:i', strtotime($past->start_time)) }}</span>
                                        </div>
                                        <p class="text-xs text-gray-500">Atendido por: <span class="font-medium text-gray-700">Dr(a). {{ $past->doctor->user->name }}</span></p>
                                    </div>
                                    <button class="px-3 py-1.5 border border-indigo-600 text-indigo-600 rounded-md text-xs font-semibold hover:bg-indigo-50 transition">
                                        Consultar Detalle
                                    </button>
                                </div>

                                <div class="bg-gray-50/80 rounded-lg p-4 space-y-2">
                                    <p class="text-xs text-gray-700"><span class="font-bold">Diagnóstico:</span> {{ $past->diagnosis ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-700"><span class="font-bold">Tratamiento:</span> {{ $past->treatment ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-700"><span class="font-bold">Notas:</span> {{ $past->notes ?? 'N/A' }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <p class="text-sm text-gray-500 italic">No hay historial previo registrado para este paciente.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Modal Footer -->
                    <div class="bg-gray-50 px-6 py-4 flex justify-end border-t border-gray-100">
                        <button type="button" wire:click="$set('showHistoryModal', false)" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-xs font-bold text-gray-700 uppercase hover:bg-gray-50 transition shadow-sm">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
