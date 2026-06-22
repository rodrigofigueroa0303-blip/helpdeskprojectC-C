<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-bold text-2xl text-brand tracking-tight">
        {{ __('Categorías de Ticket') }}
      </h2>

      <div class="flex items-center gap-3">
        @if(auth()->user()->isAdmin())
          <button id="notifBell" class="btn-secondary p-2.5 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand group-hover:rotate-12 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C8.67 6.165 8 7.388 8 8.75v5.408c0 .53-.21 1.04-.586 1.414L6 17h5m4 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            @if(session('new_ticket'))
              <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white ring-2 ring-white animate-pulse">1</span>
            @endif
          </button>
        @endif

        <a href="{{ route('admin.dashboard') }}" class="btn-secondary btn-md inline-flex items-center gap-1.5">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
          Volver al Panel
        </a>
      </div>
    </div>
  </x-slot>

  <div class="py-8">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

      @if(session('ok'))
        <div class="alert-success animate-fade-in">
          <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          <div>{{ session('ok') }}</div>
        </div>
      @endif

      <div class="card p-6 space-y-6 animate-slide-up">
        <div>
          <h3 class="text-xl font-bold text-brand tracking-tight">Listado de Categorías</h3>
          <p class="text-gray-500 text-sm mt-0.5">Administra los tipos de clasificaciones disponibles para segmentar y priorizar los tickets.</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
          <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Crear nueva categoría</h4>

          <form method="POST" action="{{ route('admin.ticket-categories.store') }}" class="flex items-center gap-4 flex-wrap">
            @csrf
            <div class="flex-1 min-w-[240px]">
              <input name="name" class="input font-medium text-gray-900" placeholder="Nombre de la categoría (Ej. Falla de Hardware)" required>
            </div>

            <label class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 cursor-pointer select-none">
              <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-brand focus:ring-brand/30" checked>
              Activa
            </label>

            <button class="btn bg-emerald-600 text-white font-semibold text-xs px-5 py-2.5 rounded-xl hover:bg-emerald-500 transition-colors shadow-sm">
              Crear categoría
            </button>
          </form>
        </div>

        <div class="overflow-hidden border border-gray-100 rounded-xl shadow-sm">
          <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
              <thead class="table-header">
                <tr>
                  <th class="table-cell">Nombre de la Categoría</th>
                  <th class="table-cell w-28 text-center">Estado</th>
                  <th class="table-cell w-[420px] text-right">Gestión en Línea</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($categories as $c)
                  <tr class="table-row">
                    <td class="table-cell font-bold text-gray-900">{{ $c->name }}</td>
                    <td class="table-cell text-center">
                      @if($c->is_active)
                        <span class="badge-emerald">Activa</span>
                      @else
                        <span class="badge-zinc">Inactiva</span>
                      @endif
                    </td>
                    <td class="px-4 py-2 text-right">
                      <div class="flex items-center justify-end gap-3">

                        <form method="POST" action="{{ route('admin.ticket-categories.update', $c) }}"
                          class="flex items-center gap-2 bg-gray-50 p-1.5 rounded-xl border border-gray-100 shadow-sm">
                          @csrf
                          @method('PUT')
                          <input name="name" value="{{ $c->name }}"
                            class="bg-white border border-gray-200 rounded-lg px-2.5 py-1 text-xs font-semibold text-gray-800 focus:border-brand focus:ring-1 focus:ring-brand/20 outline-none transition-all w-48"
                            required>

                          <label class="inline-flex items-center gap-1 text-[11px] font-bold text-gray-500 cursor-pointer select-none px-1">
                            <input type="checkbox" name="is_active" value="1"
                              class="rounded border-gray-300 text-brand focus:ring-brand/30" @checked($c->is_active)>
                            Activa
                          </label>

                          <button class="px-2.5 py-1 rounded-lg btn-primary btn-sm text-[11px]">
                            Guardar
                          </button>
                        </form>

                        <form method="POST" action="{{ route('admin.ticket-categories.destroy', $c) }}"
                          onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta categoría?')">
                          @csrf
                          @method('DELETE')
                          <button class="inline-flex items-center px-3 py-1.5 rounded-xl bg-white border border-red-100 text-xs font-semibold text-red-600 hover:bg-red-50 transition shadow-sm">
                            Eliminar
                          </button>
                        </form>

                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="px-4 py-8 text-center text-gray-400 italic">No hay categorías configuradas en la plataforma.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
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
