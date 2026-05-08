<div class="flex justify-center space-x-2">
    <!-- Botón Editar (Azul) -->
    <button class="text-white bg-blue-500 p-1.5 rounded-md hover:bg-blue-600 shadow-sm transition-all" title="Editar">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
    </button>

    <!-- Botón Consulta (Verde - Icono Estetoscopio solicitado por el maestro) -->
    <a href="{{ route('admin.consultation', $appointment) }}" class="text-white bg-green-500 p-1.5 rounded-md hover:bg-green-600 shadow-sm transition-all" title="Atender Consulta">
        <!-- SVG de Estetoscopio (fa-stethoscope) -->
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 512 512">
            <path d="M464 256h-24c-13.3 0-24 10.7-24 24v24c0 44.1-35.9 80-80 80h-24c-13.3 0-24 10.7-24 24v24c0 13.3 10.7 24 24 24h24c70.7 0 128-57.3 128-128v-24c0-13.3-10.7-24-24-24zm-224 0c-13.3 0-24 10.7-24 24v24c0 13.3 10.7 24 24 24h24c70.7 0 128-57.3 128-128v-24c0-13.3-10.7-24-24-24h-24c-13.3 0-24 10.7-24 24v24c0 44.1-35.9 80-80 80h-24zM80 0c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24h24c13.3 0 24-10.7 24-24V24c0-13.3-10.7-24-24-24H80zm128 352H144v-48h64v-64h-64v-48h64c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64C28.7 0 0 28.7 0 64v64c0 35.3 28.7 64 64 64h64v48H64v64h64v48H64c-35.3 0-64 28.7-64 64v128c0 35.3 28.7 64 64 64h144c35.3 0 64-28.7 64-64v-128c0-35.3-28.7-64-64-64z"/>
        </svg>
    </a>
</div>
