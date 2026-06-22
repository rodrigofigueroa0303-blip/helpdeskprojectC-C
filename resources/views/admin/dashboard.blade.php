<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-brand tracking-tight">
                {{ __('Panel de Administración') }}
            </h2>
            @vite(['resources/js/admin-users.js'])
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="card p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 animate-fade-in">
                <div>
                    <h1 class="text-2xl font-bold text-brand tracking-tight">Bienvenido, Administrador</h1>
                    <p class="text-gray-500 text-sm mt-0.5">Administra usuarios y configuraciones globales del sistema Helpdesk.</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('tickets.index') }}" class="btn-primary btn-md inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Gestionar Tickets
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn-secondary btn-md">
                        Volver al Dashboard
                    </a>
                </div>
            </div>

            @if(session('ok') || session('error'))
                <div class="space-y-2 animate-fade-in">
                    @if(session('ok'))
                        <div class="alert-success">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>{{ session('ok') }}</div>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert-error">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif
                </div>
            @endif

            @if(auth()->user()->isAdmin())
                <div class="card p-6 animate-slide-up">
                    <h3 class="text-base font-bold mb-4 text-brand uppercase tracking-wider text-xs">Configuración de helpdesk</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <a href="{{ route('admin.departments.index') }}"
                            class="flex items-center justify-between p-3.5 rounded-xl bg-gray-50 text-gray-700 hover:bg-brand hover:text-white transition-all group border border-gray-100">
                            <span class="font-medium text-sm">Departamentos</span>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                        <a href="{{ route('admin.ticket-categories.index') }}"
                            class="flex items-center justify-between p-3.5 rounded-xl bg-gray-50 text-gray-700 hover:bg-brand hover:text-white transition-all group border border-gray-100">
                            <span class="font-medium text-sm">Categorías de ticket</span>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                        <a href="{{ route('admin.passwords.index') }}"
                            class="flex items-center justify-between p-3.5 rounded-xl bg-gray-50 text-gray-700 hover:bg-brand hover:text-white transition-all group border border-gray-100">
                            <span class="font-medium text-sm">Gestor de contraseñas</span>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            @endif

            <div class="card p-6 space-y-8">

                <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <div>
                        <h2 class="text-md font-bold text-brand uppercase tracking-wider text-xs">Crear nuevo usuario</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Registra una nueva cuenta asignándole un rol inicial.</p>
                    </div>
                    <a href="{{ route('admin.users.create') }}"
                        class="btn-primary btn-sm inline-flex items-center gap-1.5 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Nuevo Usuario
                    </a>
                </div>

                <hr class="border-gray-100">

                <div>
                    <h2 class="text-md font-bold text-brand mb-4 uppercase tracking-wider text-xs">Usuarios registrados</h2>

                    <form method="GET" class="mb-4 flex flex-wrap gap-2 items-end">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Buscar</label>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Nombre o email..." class="input text-sm w-52">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Rol</label>
                            <select name="role" class="select text-sm">
                                <option value="">Todos</option>
                                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Usuario</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-primary btn-sm">Filtrar</button>
                        @if(request()->anyFilled(['q', 'role']))
                            <a href="{{ url()->current() }}" class="btn-secondary btn-sm">Limpiar</a>
                        @endif
                    </form>

                    <div class="overflow-hidden border border-gray-100 rounded-xl shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-600">
                                <thead class="table-header">
                                    <tr>
                                        <th class="table-cell font-bold text-center w-12">ID</th>
                                        <th class="table-cell">Nombre</th>
                                        <th class="table-cell">Email</th>
                                        <th class="table-cell w-32">Rol</th>
                                        <th class="table-cell w-40">Fecha Registro</th>
                                        <th class="table-cell w-44 text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @forelse($users as $u)
                                        <tr class="table-row">
                                            <td class="table-cell font-medium text-gray-400 text-center text-xs">
                                                {{ $u->id }}
                                            </td>
                                            <td class="table-cell font-medium text-gray-900">{{ $u->name }}</td>
                                            <td class="table-cell text-gray-500">{{ $u->email }}</td>
                                            <td class="table-cell">
                                                @if($u->role === 'admin')
                                                    <span class="badge-blue">{{ $u->role }}</span>
                                                @else
                                                    <span class="badge-zinc">{{ $u->role }}</span>
                                                @endif
                                            </td>
                                            <td class="table-cell text-xs text-gray-400">
                                                {{ optional($u->created_at)->format('d-m-Y H:i') }}
                                            </td>
                                            <td class="table-cell text-right">
                                                @if($u->id === auth()->id())
                                                    <span class="text-xs text-gray-400 italic font-medium px-2 py-1 bg-gray-50 rounded-md">Tu cuenta</span>
                                                @else
                                                    <div class="inline-flex items-center justify-end gap-1.5">
                                                        <button type="button"
                                                            onclick="openEditModal({{ json_encode($u) }}, '{{ route('admin.users.update', $u) }}')"
                                                            class="inline-flex items-center px-2.5 py-1 rounded-lg bg-white border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition shadow-sm">
                                                            Editar
                                                        </button>

                                                        <button type="button"
                                                            onclick="openDeleteUserModal('{{ $u->name }}', '{{ route('admin.users.destroy', $u) }}')"
                                                            class="inline-flex items-center px-2.5 py-1 rounded-lg bg-white border border-red-100 text-xs font-semibold text-red-600 hover:bg-red-50 transition shadow-sm">
                                                            Eliminar
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-8 text-center text-gray-400 italic">No se encontraron usuarios registrados en la base de datos.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if($users->hasPages())
                    <div class="pt-6 border-t border-gray-200 mt-4">
                        <div class="pagination-container p-3">
                            {{ $users->withQueryString()->links('pagination::tailwind') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="editUserModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" onclick="closeEditModal()"></div>
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-elevated transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100 animate-fade-in">

                <div class="bg-white px-6 pt-5 pb-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-brand">Editar Usuario</h3>
                        <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500 transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                <form id="editUserForm" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <div class="bg-white px-6 py-4 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre Completo</label>
                            <input type="text" id="edit_name" name="name" class="input" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Correo Electrónico</label>
                            <input type="email" id="edit_email" name="email" class="input" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Rol del Sistema</label>
                            <select id="edit_role" name="role" class="select" required>
                                <option value="user">User (Usuario)</option>
                                <option value="admin">Admin (Administrador)</option>
                            </select>
                        </div>

                        <div class="pt-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-0.5">Contraseña (Opcional)</label>
                            <span class="block text-[11px] text-gray-400 mb-1">Deja este campo vacío si no deseas modificar la clave actual.</span>
                            <input type="password" name="password" class="input" placeholder="Nueva contraseña">
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3.5 flex justify-end gap-2 border-t border-gray-200">
                        <button type="button" onclick="closeEditModal()" class="btn-secondary btn-sm">Cancelar</button>
                        <button type="submit" class="btn-primary btn-sm">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="deleteUserModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" onclick="closeDeleteUserModal()"></div>
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-elevated transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100 animate-fade-in">

                <div class="bg-white px-6 pt-5 pb-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-red-600">Eliminar Cuenta de Usuario</h3>
                        <button type="button" onclick="closeDeleteUserModal()" class="text-gray-400 hover:text-gray-500 transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                <form id="deleteUserForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="bg-white px-6 py-6">
                        <p class="text-sm text-gray-600">
                            ¿Estás completamente seguro de que deseas eliminar la cuenta del usuario <span id="delete_username" class="font-bold text-red-600"></span>?
                        </p>
                        <p class="text-xs text-red-600 mt-2 bg-red-50 p-2.5 rounded-xl border border-red-100 font-medium">
                            Advertencia: Esta acción removerá el acceso de forma inmediata y permanente de la base de datos. No se puede deshacer.
                        </p>
                    </div>
                    <div class="bg-gray-50 px-6 py-3.5 flex justify-end gap-2 border-t border-gray-200">
                        <button type="button" onclick="closeDeleteUserModal()" class="btn-secondary btn-sm">Cancelar</button>
                        <button type="submit" class="btn-danger btn-sm">Eliminar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
