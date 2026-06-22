<x-app-layout>
    @php
        $prev = url()->previous();
        $fallback = route('tickets.index');
        $backUrl = \Illuminate\Support\Str::contains($prev, ['/dashboard', '/tickets'])
            ? $prev
            : $fallback;

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

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-brand tracking-tight">
                {{ __('Detalle del Ticket') }}
            </h2>

            <div class="flex items-center gap-3">
                @if(auth()->user()->isAdmin())
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
                @endif

                <a href="{{ $backUrl }}" class="btn-secondary btn-md inline-flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 grid gap-6">

            @if(session('ok') || session('error'))
                <div class="space-y-2">
                    @if(session('ok'))
                        <div class="alert-success animate-fade-in">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>{{ session('ok') }}</div>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert-error animate-fade-in">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif
                </div>
            @endif

            <div class="card p-6 space-y-4 animate-fade-in">
                <div class="flex items-start justify-between gap-4">
                    <div class="space-y-2">
                        <div class="flex items-center gap-1.5">
                            <span class="{{ $statusColors[$ticket->status] ?? 'badge-zinc' }}">
                                {{ $ticket->status }}
                            </span>
                            <span class="{{ $priorityColors[$ticket->priority] ?? 'badge-zinc' }}">
                                {{ $ticket->priority }}
                            </span>
                        </div>
                        
                        <h1 class="text-2xl font-black text-brand tracking-tight leading-snug">{{ $ticket->subject }}</h1>
                        
                        <div class="text-xs text-gray-500 font-medium flex flex-wrap items-center gap-1.5 mt-1">
                            <span class="font-bold text-brand text-sm">{{ $ticket->requester?->display_name }}</span>
                            <span class="text-gray-300">·</span>
                            <span>{{ $ticket->department ?? 'Sin depto.' }}</span>
                            @if($ticket->category)
                                <span class="text-gray-300">·</span>
                                <span>{{ $ticket->category }}</span>
                            @endif
                            @if($ticket->assignee)
                                <span class="text-gray-300">·</span>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-gray-50 text-gray-600 border border-gray-200 font-semibold">
                                    Asignado: {{ $ticket->assignee->display_name }}
                                </span>
                            @endif
                            @if($ticket->closed_at)
                                <span class="text-gray-300">·</span>
                                <span class="text-zinc-600 font-semibold">Cerrado: {{ $ticket->closed_at->format('d-m-Y H:i') }}</span>
                            @endif
                        </div>
                    </div>

                    @if($ticket->status !== 'Cerrado' || auth()->user()->isAdmin())
                        <a href="{{ route('tickets.edit', $ticket) }}"
                           class="btn-secondary btn-sm shrink-0 inline-flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Editar
                        </a>
                    @endif
                </div>

                <div class="pt-4 border-t border-gray-50">
                    <p class="whitespace-pre-wrap text-sm text-gray-700 leading-relaxed bg-gray-50/30 p-4 rounded-xl border border-gray-100 font-medium">{{ $ticket->description }}</p>
                </div>
            </div>

            @if(auth()->user()->isAdmin())
                <div class="card p-6 space-y-4 animate-slide-up">
                    <div class="border-b border-gray-50 pb-2">
                        <h2 class="text-xs font-bold text-brand uppercase tracking-wider">Acciones de administración</h2>
                    </div>

                    <form method="POST" action="{{ route('admin.tickets.adminUpdate', $ticket) }}"
                          class="grid grid-cols-1 md:grid-cols-3 items-end gap-3 bg-gray-50 p-4 rounded-xl border border-gray-100">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Estado</label>
                            <select name="status" class="select">
                                @foreach(['Nuevo','En Progreso','Resuelto','Cerrado'] as $s)
                                    <option value="{{ $s }}" @selected($ticket->status===$s)>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Asignar a</label>
                            <select name="assigned_user_id" class="select">
                                <option value="">— Sin asignar —</option>
                                @foreach($admins as $a)
                                    <option value="{{ $a->id }}" @selected($ticket->assigned_user_id===$a->id)>
                                        {{ $a->name ?: $a->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <button class="btn-primary btn-md w-full">
                                Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <div class="card p-6 space-y-4 animate-slide-up">
                <div class="border-b border-gray-50 pb-2">
                    <h2 class="text-xs font-bold text-brand uppercase tracking-wider">Historial de Comentarios</h2>
                </div>

                <div class="space-y-3 max-h-[400px] overflow-y-auto pr-1 scrollbar-thin">
                    @forelse($ticket->comments as $c)
                        <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 shadow-sm space-y-2">
                            <div class="flex items-start justify-between gap-3 flex-wrap">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-xs text-brand bg-white border border-gray-200 px-2.5 py-1 rounded-lg shadow-sm">
                                        {{ $c->author?->display_name }}
                                    </span>
                                    <span class="text-[11px] text-gray-400 font-medium">
                                        {{ $c->created_at->format('d-m-Y H:i') }}
                                    </span>
                                </div>

                                @if($c->attachment_path)
                                    <a href="{{ route('comments.download', $c) }}"
                                       class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-800 bg-blue-50/50 hover:bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-lg transition-all shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" /></svg>
                                        <span class="max-w-[150px] truncate">{{ $c->attachment_name ?? 'Archivo' }}</span>
                                    </a>
                                @endif
                            </div>

                            <div class="text-sm text-gray-700 leading-relaxed font-medium pl-0.5">
                                {!! nl2br(e($c->body)) !!}
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-gray-200 p-6 text-center text-gray-400 italic text-sm font-medium bg-gray-50/30">
                            No se han registrado comentarios ni seguimientos en esta solicitud.
                        </div>
                    @endforelse
                </div>

                <form method="POST"
                      action="{{ route('tickets.comments.store', $ticket) }}"
                      enctype="multipart/form-data"
                      class="mt-4 pt-4 border-t border-gray-50 flex flex-col gap-4 md:flex-row md:items-end bg-gray-50/40 p-4 rounded-xl border border-gray-100">
                    @csrf

                    <div class="flex-1 min-w-[250px]">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Escribir Comentario</label>
                        <input name="body"
                               class="input"
                               placeholder="Ingresa los detalles del seguimiento..."
                               required>
                    </div>

                    <div class="min-w-[240px] md:max-w-xs">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Adjuntar archivo (opcional)</label>
                        <input type="file" name="attachment" 
                               class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand file:text-white file:hover:bg-brand-700 file:cursor-pointer transition-all">
                        <p class="text-[10px] text-gray-400 font-medium mt-1">Formatos admitidos: PDF, JPG, PNG, DOCX, XLSX (Máx. 2MB)</p>
                    </div>

                    <div>
                        <button class="btn-primary btn-md w-full md:w-auto">
                            Enviar
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

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
</x-app-layout>
