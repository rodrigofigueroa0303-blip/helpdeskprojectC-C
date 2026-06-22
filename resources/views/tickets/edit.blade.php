<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-brand tracking-tight">
                {{ __('Editar Ticket') }}
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

                <a href="{{ route('tickets.show', $ticket) }}" class="btn-secondary btn-md inline-flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="alert-error mb-6 animate-fade-in">
                    <div class="flex items-center gap-2 mb-2 font-bold text-red-900">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Por favor, corrige los siguientes campos:
                    </div>
                    <ul class="list-disc list-inside space-y-1 pl-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('tickets.update', $ticket) }}"
                  class="card p-6 space-y-5 animate-slide-up">
                @csrf 
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5 tracking-wider">Asunto del Requerimiento</label>
                    <input name="subject" value="{{ old('subject', $ticket->subject) }}"
                           class="input font-medium text-gray-900" 
                           placeholder="Ej. Error en la carga de archivos del sistema" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5 tracking-wider">Departamento</label>
                        <select name="department" class="select font-medium">
                            <option value="">Seleccione departamento</option>
                            @foreach($departments as $d)
                                <option value="{{ $d }}" @selected(old('department', $ticket->department) === $d)>{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5 tracking-wider">Categoría</label>
                        <select name="category" class="select font-medium">
                            <option value="">Seleccione categoría</option>
                            @foreach($categories as $c)
                                <option value="{{ $c }}" @selected(old('category', $ticket->category) === $c)>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5 tracking-wider">Prioridad de Atención</label>
                    <select name="priority" class="select font-medium" required>
                        @foreach(['Baja','Media','Alta','Crítica'] as $p)
                            <option value="{{ $p }}" @selected(old('priority', $ticket->priority) === $p)>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                @if(auth()->user()->isAdmin())
                    <div class="p-4 bg-gray-50/70 border border-gray-100 rounded-xl space-y-1.5">
                        <label class="block text-xs font-bold text-brand uppercase tracking-wider">Estado Operativo (Exclusivo Admin)</label>
                        <select name="status" class="select font-semibold">
                            @foreach(['Nuevo','En Progreso','Resuelto','Cerrado'] as $s)
                                <option value="{{ $s }}" @selected(old('status', $ticket->status) === $s)>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5 tracking-wider">Descripción Detallada</label>
                    <textarea name="description" rows="6"
                              class="input leading-relaxed font-medium text-gray-800 resize-none" 
                              placeholder="Describe de forma clara y detallada el problema técnico o solicitud..." required>{{ old('description', $ticket->description) }}</textarea>
                </div>

                <div class="pt-3 border-t border-gray-50 flex items-center justify-end gap-2.5">
                    <a href="{{ route('tickets.show', $ticket) }}" class="btn-secondary btn-md">
                        Cancelar
                    </a>
                    <button type="submit" class="btn-primary btn-md">
                        Actualizar Requerimiento
                    </button>
                </div>
            </form>
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
