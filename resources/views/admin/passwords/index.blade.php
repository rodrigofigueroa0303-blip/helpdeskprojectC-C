<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-brand tracking-tight">
                    {{ __('Gestor de Contraseñas') }}
                </h2>
                <p class="text-xs text-gray-400 mt-1">
                    Administración segura de credenciales y accesos globales del sistema.
                </p>
            </div>
            
            <div class="flex items-center gap-3 self-start sm:self-center">
                <a href="{{ route('admin.dashboard') }}"
                   class="btn-secondary btn-md inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver al Panel
                </a>
            </div>
        </div>
        
        @vite(['resources/js/password-manager.js'])
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('ok'))
                <div class="alert-success animate-fade-in">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>{{ session('ok') }}</div>
                </div>
            @endif

            <div class="card p-6 space-y-6">
                
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-brand tracking-tight">Contraseñas registradas</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Total en el sistema: <span class="font-semibold text-gray-600">{{ $entries->total() }}</span></p>
                    </div>
                    <a href="{{ route('admin.passwords.create') }}"
                       class="btn-primary btn-md inline-flex items-center gap-2 self-start sm:self-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Nueva entrada
                    </a>
                </div>

                <form method="GET" class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <div class="relative">
                            <input name="q" value="{{ request('q') }}"
                                   class="input"
                                   placeholder="Aplicación, usuario o correo...">
                        </div>

                        <select name="estado" class="select">
                            <option value="">Estado (Todos)</option>
                            @foreach(['Nuevo','Restringido','Eliminado','De baja'] as $estado)
                                <option value="{{ $estado }}" @selected(request('estado')===$estado)>{{ $estado }}</option>
                            @endforeach
                        </select>

                        @php
                            $tipos = \App\Models\PasswordEntry::select('tipo')->distinct()->pluck('tipo');
                        @endphp
                        <select name="tipo" class="select">
                            <option value="">Tipo (Todos)</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo }}" @selected(request('tipo')===$tipo)>{{ $tipo }}</option>
                            @endforeach
                        </select>

                        <div class="flex gap-2">
                            <button type="submit" class="btn-primary btn-md w-full">
                                Filtrar lista
                            </button>
                            @if(request()->hasAny(['q','estado','tipo']) && (request('q') || request('estado') || request('tipo')))
                                <a href="{{ route('admin.passwords.index') }}"
                                   class="btn-secondary btn-md w-full">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                <div class="overflow-hidden border border-gray-100 rounded-xl shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="table-header">
                                <tr>
                                    <th class="table-cell">Tipo</th>
                                    <th class="table-cell">Aplicación</th>
                                    <th class="table-cell w-28">Estado</th>
                                    <th class="table-cell">Usuario</th>
                                    <th class="table-cell">Correo</th>
                                    <th class="table-cell w-36">Contraseña</th>
                                    <th class="table-cell w-28">Creación</th>
                                    <th class="table-cell w-28">Eliminación</th>
                                    <th class="table-cell w-36 text-center">Acciones</th>
                                    <th class="table-cell">Observaciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($entries as $e)
                                    <tr class="table-row">
                                        <td class="table-cell font-medium text-gray-900 text-xs uppercase">{{ $e->tipo }}</td>
                                        <td class="table-cell font-bold text-brand">{{ $e->aplicacion }}</td>
                                        <td class="table-cell">
                                            @switch($e->estado)
                                                @case('Nuevo')
                                                    <span class="badge-emerald">{{ $e->estado }}</span>
                                                    @break
                                                @case('Restringido')
                                                    <span class="badge-purple">{{ $e->estado }}</span>
                                                    @break
                                                @case('De baja')
                                                    <span class="badge-amber">{{ $e->estado }}</span>
                                                    @break
                                                @default
                                                    <span class="badge-red">{{ $e->estado }}</span>
                                            @endswitch
                                        </td>
                                        <td class="table-cell text-gray-700">{{ $e->usuario ?: '—' }}</td>
                                        <td class="table-cell text-gray-500 text-xs">{{ $e->correo ?: '—' }}</td>

                                        <td class="table-cell">
                                            <div class="flex items-center justify-between gap-1.5 bg-gray-50 border border-gray-100 px-2 py-1 rounded-lg w-fit min-w-[100px]">
                                                <span class="font-mono tracking-widest text-xs">
                                                    <span class="pw-mask text-gray-400">••••••••</span>
                                                    <span class="pw-real hidden text-gray-800 font-semibold select-all">{{ $e->password_decrypted ?? $e->password ?? '' }}</span>
                                                </span>
                                                <button type="button" class="text-[10px] uppercase font-bold text-blue-600 hover:text-blue-800 transition-colors pw-toggle outline-none">
                                                    ver
                                                </button>
                                            </div>
                                        </td>

                                        <td class="table-cell text-xs text-gray-400">{{ $e->fecha_creacion ? \Carbon\Carbon::parse($e->fecha_creacion)->format('d-m-Y') : '—' }}</td>
                                        <td class="table-cell text-xs text-gray-400">{{ $e->fecha_eliminacion ? \Carbon\Carbon::parse($e->fecha_eliminacion)->format('d-m-Y') : '—' }}</td>

                                        <td class="table-cell text-center">
                                            <div class="inline-flex items-center gap-1.5 justify-center">
                                                <a href="{{ route('admin.passwords.edit', $e) }}"
                                                   title="Editar registro"
                                                   class="inline-flex items-center p-1.5 rounded-lg bg-white border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-100 transition shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232a2.5 2.5 0 113.536 3.536L8.5 19.036H5v-3.572l10.232-10.232z" />
                                                    </svg>
                                                </a>

                                                @if($e->estado !== 'De baja')
                                                    <button type="button" 
                                                            onclick="triggerBajaModal('{{ $e->aplicacion }}', '{{ route('admin.passwords.baja', $e) }}')"
                                                            title="Dar de baja"
                                                            class="inline-flex items-center p-1.5 rounded-lg bg-white border border-gray-200 text-amber-500 hover:text-amber-700 hover:border-amber-100 transition shadow-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8" />
                                                        </svg>
                                                    </button>
                                                @endif

                                                <button type="button" 
                                                        onclick="triggerDeleteModal('{{ $e->aplicacion }}', '{{ route('admin.passwords.destroy', $e) }}')"
                                                        title="Eliminar definitivamente"
                                                        class="inline-flex items-center p-1.5 rounded-lg bg-white border border-red-100 text-rose-500 hover:bg-rose-50 transition shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>

                                        <td class="table-cell text-xs text-gray-400 max-w-xs truncate" title="{{ $e->observaciones }}">
                                            {{ $e->observaciones ?: '—' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="px-4 py-8 text-center text-gray-400 italic">No se encontraron credenciales que coincidan con los criterios de búsqueda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($entries->hasPages())
                    <div class="pt-4 border-t border-gray-100">
                        {{ $entries->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    <div id="bajaModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeBajaModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-elevated transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-amber-50 sm:mx-0 sm:h-10 sm:w-10 border border-amber-200">
                            <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-bold text-brand" id="modal-title">Dar de baja credencial</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">¿Estás seguro de que deseas marcar como inactiva la cuenta de <span id="bajaAppName" class="font-bold text-gray-800"></span>? Esta acción cambiará su estado visual pero mantendrá el registro histórico.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                    <form id="bajaForm" method="POST" action="">
                        @csrf @method('PUT')
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-amber-500 text-base font-medium text-white hover:bg-amber-600 focus:outline-none sm:text-sm transition-all">
                            Confirmar Baja
                        </button>
                    </form>
                    <button type="button" onclick="closeBajaModal()" class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:text-sm transition-all">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeDeleteModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-elevated transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-50 sm:mx-0 sm:h-10 sm:w-10 border border-red-200">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-bold text-red-600" id="modal-title">Eliminación Permanente</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">¿Estás completamente seguro de eliminar permanentemente el acceso a <span id="deleteAppName" class="font-bold text-gray-900"></span>? Esta acción **no se puede deshacer** y los datos se borrarán definitivamente del sistema corporativo.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                    <form id="deleteForm" method="POST" action="">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:text-sm transition-all">
                            Eliminar Definitivamente
                        </button>
                    </form>
                    <button type="button" onclick="closeDeleteModal()" class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:text-sm transition-all">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
