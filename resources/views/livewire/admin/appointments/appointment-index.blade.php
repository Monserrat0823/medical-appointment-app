<div>
    <x-slot name="action">
        <a href="{{ route('admin.appointments.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition shadow-sm">
            + Nuevo
        </a>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session()->has('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex items-center" role="alert">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <p class="text-sm font-bold">{{ session('success') }}</p>
                </div>
            @endif
            
            <!-- Search and Pagination Controls Section -->
            <div class="flex justify-between items-center mb-4">
                <div class="w-64">
                    <input type="text" wire:model.live="search" placeholder="Buscar" class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm p-2 transition-all bg-white">
                </div>
                <div class="flex items-center space-x-2">
                    <div class="flex items-center space-x-1">
                        <select class="border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm p-1.5 pr-8 bg-white text-gray-600 cursor-pointer">
                            <option>Columnas</option>
                        </select>
                    </div>
                    <div>
                        <select wire:model.live="perPage" class="border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm p-1.5 pr-8 bg-white text-gray-600 cursor-pointer">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                <!-- Table Section -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <span>ID</span>
                                        <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10l5-5 5 5M7 14l5 5 5-5"></path></svg>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <span>PACIENTE</span>
                                        <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10l5-5 5 5M7 14l5 5 5-5"></path></svg>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <span>DOCTOR</span>
                                        <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10l5-5 5 5M7 14l5 5 5-5"></path></svg>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <span>FECHA</span>
                                        <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10l5-5 5 5M7 14l5 5 5-5"></path></svg>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <span>HORA</span>
                                        <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10l5-5 5 5M7 14l5 5 5-5"></path></svg>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <span>HORA FIN</span>
                                        <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10l5-5 5 5M7 14l5 5 5-5"></path></svg>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ESTADO</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($appointments as $appointment)
                                <tr class="odd:bg-white even:bg-gray-50/30 hover:bg-gray-100/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $appointment->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $appointment->patient->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $appointment->doctor->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $appointment->date->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $appointment->start_time }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $appointment->end_time }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $appointment->status == 1 ? 'Programada' : ($appointment->status == 2 ? 'Completada' : 'Cancelada') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @include('admin.appointments.actions', ['appointment' => $appointment])
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                    {{ $appointments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
