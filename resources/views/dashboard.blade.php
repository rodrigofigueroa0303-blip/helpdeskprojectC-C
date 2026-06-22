<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-brand tracking-tight">
                Dashboard
            </h2>

            @if(auth()->user()->isAdmin())
                <div class="relative">
                    <button id="notifBell" class="btn-secondary p-2.5 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand group-hover:rotate-12 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C8.67 6.165 8 7.388 8 8.75v5.408c0 .53-.21 1.04-.586 1.414L6 17h5m4 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if(session('new_ticket'))
                            <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white ring-2 ring-white animate-pulse">
                                1
                            </span>
                        @endif
                    </button>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Tarjeta de bienvenida --}}
            <div class="card p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 animate-fade-in">
                <div>
                    <h1 class="text-2xl font-bold text-brand tracking-tight">¡Bienvenido/a, {{ auth()->user()->name }}!</h1>
                    <p class="text-gray-500 text-sm mt-0.5">Desde aquí puedes gestionar tus tickets o acceder al panel administrativo del sistema.</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn-primary btn-md inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Panel Admin
                        </a>
                    @endif
                    <a href="{{ route('tickets.index') }}" class="btn-primary btn-md inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        Ir a Tickets
                    </a>
                </div>
            </div>

            {{-- Mis tickets por estado --}}
            <div class="card p-6 space-y-4 animate-slide-up">
                <h3 class="text-brand font-bold uppercase tracking-wider text-xs">Mis Tickets por Estado</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($statuses as $s)
                        @php
                            $badgeClass = [
                                'Nuevo'       => 'badge-blue',
                                'En Progreso' => 'badge-amber',
                                'Resuelto'    => 'badge-emerald',
                                'Cerrado'     => 'badge-zinc',
                            ][$s] ?? 'badge-zinc';

                            $hoverColor = [
                                'Nuevo'       => 'hover:border-blue-300 hover:bg-blue-50/20',
                                'En Progreso' => 'hover:border-amber-300 hover:bg-amber-50/20',
                                'Resuelto'    => 'hover:border-emerald-300 hover:bg-emerald-50/20',
                                'Cerrado'     => 'hover:border-zinc-300 hover:bg-zinc-50/20',
                            ][$s] ?? 'hover:border-gray-300';
                        @endphp
                        <a href="{{ route('tickets.index', ['status'=>$s]) }}"
                           class="block rounded-xl border border-gray-100 bg-white p-4 shadow-soft transition-all duration-200 group {{ $hoverColor }}">
                            <div class="flex items-center justify-between">
                                <span class="{{ $badgeClass }}">{{ $s }}</span>
                                <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-400 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                            <div class="text-3xl font-black text-brand mt-4 tracking-tight">{{ $mine[$s] ?? 0 }}</div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Resumen admin --}}
            @if(auth()->user()->isAdmin())
                <div class="card p-6 space-y-6 animate-slide-up">
                    <div>
                        <h3 class="text-brand font-bold uppercase tracking-wider text-xs mb-1">Resumen Global</h3>
                        <p class="text-xs text-gray-400">Estado consolidado de la mesa de ayuda general.</p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($statuses as $s)
                            <a href="{{ route('tickets.index', ['status'=>$s]) }}"
                               class="block bg-gray-50/50 border border-gray-100 rounded-xl p-4 transition-all hover:bg-gray-50 shadow-sm">
                                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $s }}</div>
                                <div class="text-2xl font-bold text-brand mt-2">{{ $all[$s] ?? 0 }}</div>
                            </a>
                        @endforeach
                    </div>

                    @if(session('ok'))
                        <div class="alert-success">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>{{ session('ok') }}</div>
                        </div>
                    @endif

                    <hr class="border-gray-100">

                    {{-- Últimos tickets creados --}}
                    <div>
                        <h4 class="text-md font-bold text-brand mb-4 uppercase tracking-wider text-xs">Últimos tickets creados</h4>

                        <div class="overflow-hidden border border-gray-100 rounded-xl shadow-sm">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-600">
                                    <thead class="table-header">
                                        <tr>
                                            <th class="table-cell font-bold text-center w-10">ID</th>
                                            <th class="table-cell min-w-[160px]">Asunto</th>
                                            <th class="table-cell hidden sm:table-cell">Solicitante</th>
                                            <th class="table-cell hidden md:table-cell">Depto</th>
                                            <th class="table-cell hidden lg:table-cell">Categoría</th>
                                            <th class="table-cell w-20">Prioridad</th>
                                            <th class="table-cell w-24">Estado</th>
                                            <th class="table-cell hidden xl:table-cell">Asignado</th>
                                            <th class="table-cell hidden sm:table-cell w-32">Creado</th>
                                            <th class="table-cell hidden lg:table-cell w-32">Cerrado</th>
                                            <th class="table-cell w-14 text-center sticky right-0 bg-gray-50 shadow-[-8px_0_12px_-6px_rgba(0,0,0,0.08)]">Eliminar</th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        @forelse($lastTickets as $t)
                                            @php
                                                $statusPill = [
                                                    'Nuevo'       => 'badge-blue',
                                                    'En Progreso' => 'badge-amber',
                                                    'Resuelto'    => 'badge-emerald',
                                                    'Cerrado'     => 'badge-zinc',
                                                ][$t->status] ?? 'bg-gray-50 text-gray-600';

                                                $prioPill = [
                                                    'Baja'    => 'badge-zinc',
                                                    'Media'   => 'badge-sky',
                                                    'Alta'    => 'badge-orange',
                                                    'Crítica' => 'badge-rose',
                                                ][$t->priority] ?? 'bg-gray-50 text-gray-600';
                                            @endphp

                                            <tr class="table-row">
                                                <td class="table-cell font-medium text-center text-xs">
                                                    <a href="{{ route('tickets.show',$t) }}" class="text-blue-600 hover:underline font-semibold">
                                                        #{{ $t->id }}
                                                    </a>
                                                </td>

                                                <td class="table-cell font-semibold text-brand max-w-[200px] truncate">
                                                    <a href="{{ route('tickets.show',$t) }}" class="hover:underline">
                                                        {{ $t->subject }}
                                                    </a>
                                                </td>

                                                <td class="table-cell font-medium text-gray-900 hidden sm:table-cell">
                                                    {{ $t->requester?->display_name }}
                                                </td>

                                                <td class="table-cell text-gray-500 text-xs hidden md:table-cell">{{ $t->department ?? '—' }}</td>
                                                <td class="table-cell text-gray-500 text-xs hidden lg:table-cell">{{ $t->category ?? '—' }}</td>

                                                <td class="table-cell">
                                                    <span class="{{ $prioPill }}">{{ $t->priority }}</span>
                                                </td>

                                                <td class="table-cell">
                                                    <span class="{{ $statusPill }}">{{ $t->status }}</span>
                                                </td>

                                                <td class="table-cell text-gray-700 font-medium text-xs hidden xl:table-cell">
                                                    {{ $t->assignee?->display_name ?? '—' }}
                                                </td>

                                                <td class="table-cell text-xs text-gray-400 hidden sm:table-cell whitespace-nowrap">
                                                    {{ $t->created_at?->format('d-m-Y H:i') ?? '—' }}
                                                </td>

                                                <td class="table-cell text-xs text-gray-400 hidden lg:table-cell whitespace-nowrap">
                                                    {{ $t->closed_at ? $t->closed_at->format('d-m-Y H:i') : '—' }}
                                                </td>

                                                <td class="table-cell text-center sticky right-0 bg-white shadow-[-8px_0_12px_-6px_rgba(0,0,0,0.08)]">
                                                    <button type="button"
                                                            onclick="confirmDeleteTicket({{ $t->id }}, '{{ route('admin.tickets.destroy', $t) }}')"
                                                            class="inline-flex items-center justify-center p-1.5 rounded-lg text-red-500 hover:text-white hover:bg-red-500 transition-colors"
                                                            title="Eliminar ticket #{{ $t->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="px-4 py-8 text-center text-gray-400 italic">
                                                    No hay tickets registrados todavía.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- SweetAlert: Nuevo ticket automático para admins --}}
    @if(auth()->user()->isAdmin() && session('new_ticket'))
        <script>
            Swal.fire({
                title: '¡Nuevo ticket!',
                text: 'Se ha registrado un nuevo ticket en el sistema.',
                icon: 'info',
                confirmButtonText: 'Ok'
            });
        </script>
    @endif

    {{-- Script global para confirmación de eliminación con SweetAlert --}}
    <script>
        function confirmDeleteTicket(ticketId, actionUrl) {
            Swal.fire({
                title: '¿Eliminar ticket?',
                text: 'Esta acción no se puede deshacer. ¿Estás seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = actionUrl;
                    form.style.display = 'none';

                    let csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    let method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
</x-app-layout>
