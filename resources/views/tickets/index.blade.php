<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-brand tracking-tight">
                {{ __('Tickets') }}
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

    @php
        $statusColors = [
            'Nuevo'       => 'badge-blue',
            'En Progreso' => 'badge-amber',
            'Resuelto'    => 'badge-emerald',
            'Cerrado'     => 'badge-zinc',
        ];
        $priorityColors = [
            'Baja'    => 'badge-zinc',
            'Media'   => 'badge-sky',
            'Alta'    => 'badge-orange',
            'Crítica' => 'badge-rose',
        ];
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('ok'))
                <div class="alert-success animate-fade-in">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>{{ session('ok') }}</div>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-brand tracking-tight">Listado de Tickets</h1>
                    <p class="text-gray-500 text-sm mt-0.5">Visualiza, filtra y haz seguimiento a tus solicitudes de soporte.</p>
                </div>

                <a href="{{ route('tickets.create') }}" class="btn-primary btn-md inline-flex items-center gap-2 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Nuevo Ticket
                </a>
            </div>

            <form method="GET" class="card p-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div class="md:col-span-1">
                        <input name="q" value="{{ request('q') }}"
                               class="input"
                               placeholder="Buscar palabra clave...">
                    </div>

                    <div>
                        <select name="status" class="select">
                            <option value="">Estado (Todos)</option>
                            @foreach(['Nuevo','En Progreso','Resuelto','Cerrado'] as $s)
                                <option value="{{ $s }}" @selected(request('status')===$s)>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="priority" class="select">
                            <option value="">Prioridad (Todas)</option>
                            @foreach(['Baja','Media','Alta','Crítica'] as $p)
                                <option value="{{ $p }}" @selected(request('priority')===$p)>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button class="btn-primary btn-md w-full md:w-auto">
                            Filtrar
                        </button>
                        @if(request()->hasAny(['q','status','priority']) && (request('q')||request('status')||request('priority')))
                            <a href="{{ route('tickets.index') }}" class="btn-secondary btn-md w-full md:w-auto">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            @if($tickets->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($tickets as $t)
                        @php
                            $hoverCardColor = [
                                'Nuevo'       => 'hover:border-blue-300',
                                'En Progreso' => 'hover:border-amber-300',
                                'Resuelto'    => 'hover:border-emerald-300',
                                'Cerrado'     => 'hover:border-zinc-300',
                            ][$t->status] ?? 'hover:border-gray-300';
                        @endphp
                        <a href="{{ route('tickets.show',$t) }}"
                           class="group block card-hover p-5 {{ $hoverCardColor }} animate-fade-in">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="text-[16px] font-bold text-brand group-hover:text-brand-700 tracking-tight line-clamp-2">
                                    {{ $t->subject }}
                                </h3>
                                
                                <div class="shrink-0 flex flex-col items-end gap-1.5">
                                    <span class="{{ $statusColors[$t->status] ?? 'badge-zinc' }}">
                                        {{ $t->status }}
                                    </span>
                                    <span class="{{ $priorityColors[$t->priority] ?? 'badge-zinc' }}">
                                        {{ $t->priority }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-gray-50 grid grid-cols-1 gap-1 text-xs text-gray-500">
                                <div class="flex items-center gap-1 truncate">
                                    <span class="font-bold text-brand text-sm truncate">{{ $t->requester?->display_name }}</span>
                                </div>
                                <div class="text-gray-400 font-medium mt-0.5">
                                    <span>{{ $t->department ?? 'Sin depto.' }}</span>
                                    @if($t->category)
                                        <span class="mx-1.5">·</span><span>{{ $t->category }}</span>
                                    @endif
                                </div>
                                
                                @if($t->assignee)
                                    <div class="mt-1 flex items-center gap-1 text-brand bg-gray-50 px-2 py-1 rounded-lg w-max max-w-full truncate font-medium">
                                        <span class="text-gray-400 font-normal">Asignado:</span>
                                        <span class="truncate">{{ $t->assignee->display_name }}</span>
                                    </div>
                                @endif
                                
                                @if($t->closed_at)
                                    <div class="mt-1 text-zinc-500 font-medium">
                                        Cerrado: {{ $t->closed_at->format('d-m-Y H:i') }}
                                    </div>
                                @endif
                            </div>

                            <p class="mt-3.5 text-sm text-gray-600 line-clamp-2 leading-relaxed bg-gray-50/40 p-2 rounded-xl border border-gray-100">
                                {{ $t->description }}
                            </p>
                        </a>
                    @endforeach
                </div>

                <div class="pt-4">
                    <div class="pagination-container p-3">
                        {{ $tickets->onEachSide(1)->links() }}
                    </div>
                </div>
            @else
                <div class="card max-w-md mx-auto p-12 text-center border-dashed border-gray-300 animate-fade-in">
                    <div class="mx-auto mb-4 h-12 w-12 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-gray-900 font-bold text-base tracking-tight">Sin resultados</h3>
                    <p class="text-sm text-gray-400 mt-1">Aún no hay tickets que coincidan con los criterios del filtro de búsqueda.</p>
                    <div class="mt-5">
                        <a href="{{ route('tickets.create') }}" class="btn-primary btn-md">
                            Crear mi primer ticket
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
