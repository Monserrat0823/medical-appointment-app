<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Gestor de horarios</h1>
                <p class="text-sm text-gray-500">Configura la disponibilidad semanal del doctor(a): <span class="font-semibold text-gray-700">{{ $doctor->user->name }}</span> | <span class="text-indigo-600 font-bold">{{ count($selectedSlots, COUNT_RECURSIVE) - count($selectedSlots) }} slots seleccionados</span></p>
            </div>
            <button type="button" wire:click="save" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                Guardar horario
            </button>
        </div>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-100 p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                            <th class="px-4 py-3 text-left w-32">DÍA/HORA</th>
                            @foreach($days as $id => $name)
                                <th class="px-6 py-3 text-left">{{ $name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($hours as $hour)
                            @php
                                $slots = $this->getSlotsForHour($hour);
                            @endphp
                            <tr class="group">
                                <td class="px-4 py-6 align-top">
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer w-5 h-5">
                                        <span class="text-sm font-bold text-gray-800">{{ $hour }}</span>
                                    </div>
                                </td>
                                
                                @foreach($days as $dayId => $dayName)
                                    <td class="px-6 py-6 align-top">
                                        <div class="space-y-3">
                                            <!-- Todos option -->
                                            <label class="flex items-center space-x-3 cursor-pointer group/item">
                                                <input type="checkbox" 
                                                       wire:click="toggleHourGroup({{ $dayId }}, '{{ $hour }}')"
                                                       @php
                                                           $allChecked = true;
                                                           foreach($slots as $s) {
                                                               if(!isset($selectedSlots[$dayId][$s['start']])) { $allChecked = false; break; }
                                                           }
                                                       @endphp
                                                       @if($allChecked) checked @endif
                                                       class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4 cursor-pointer">
                                                <span class="text-xs font-medium text-gray-500 group-hover/item:text-gray-800 transition-colors">Todos</span>
                                            </label>

                                            <!-- Individual Slots -->
                                            @foreach($slots as $slot)
                                                <label class="flex items-center space-x-3 cursor-pointer group/item">
                                                    <input type="checkbox" 
                                                           wire:click="toggleSlot({{ $dayId }}, '{{ $slot['start'] }}')"
                                                           @if(isset($selectedSlots[$dayId][$slot['start']])) checked @endif
                                                           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4 cursor-pointer">
                                                    <span class="text-xs font-medium text-gray-500 group-hover/item:text-gray-800 transition-colors">{{ $slot['label'] }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if (session()->has('swal'))
        <script>
            Swal.fire({
                icon: '{{ session('swal.icon') }}',
                title: '{{ session('swal.title') }}',
                text: '{{ session('swal.text') }}',
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                position: 'top-end'
            });
        </script>
    @endif
</div>
