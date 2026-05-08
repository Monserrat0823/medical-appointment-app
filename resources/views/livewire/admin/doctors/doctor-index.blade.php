<div>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Search and Pagination Controls Section -->
            <div class="flex justify-between items-center mb-4">
                <div class="w-64">
                    <input type="text" wire:model.live="search" placeholder="Buscar" class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm p-2 transition-all bg-white placeholder:text-gray-400/70">
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
                                <th class="px-4 py-3 text-left">
                                    <div class="flex items-center space-x-1 text-xs font-semibold text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700">
                                        <span>ID</span>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left">
                                    <div class="flex items-center space-x-1 text-xs font-semibold text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700">
                                        <span>Nombre</span>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">DNI</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Teléfono</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Especialidad</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($doctors as $doctor)
                                <tr class="hover:bg-gray-50/50 transition-colors odd:bg-white even:bg-gray-50/30">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">{{ $doctor->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-800">{{ $doctor->user->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $doctor->user->email }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">{{ $doctor->user->id_number }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">{{ $doctor->user->phone ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                            {{ $doctor->specialty }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center space-x-2">
                                            <a href="#" class="p-1.5 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition shadow-sm" title="Editar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <a href="{{ route('admin.doctors.schedule', $doctor) }}" class="p-1.5 bg-green-500 text-white rounded-md hover:bg-green-600 transition shadow-sm" title="Horarios">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500 italic">
                                        No se encontraron doctores registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Area -->
                <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                    {{ $doctors->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
