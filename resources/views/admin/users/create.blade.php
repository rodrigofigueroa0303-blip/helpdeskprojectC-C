<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-brand tracking-tight">
                {{ __('Crear Nuevo Usuario') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="card p-6 animate-fade-in">

                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-xl font-bold text-brand tracking-tight">Nuevo Usuario</h1>
                        <p class="text-xs text-gray-400 mt-0.5">Registra una nueva cuenta asignándole un rol inicial.</p>
                    </div>
                    <a href="{{ route('admin.dashboard') }}"
                        class="btn-secondary btn-sm inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Volver
                    </a>
                </div>

                @if ($errors->any())
                    <div class="alert-error mb-6">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nombre Completo</label>
                        <input name="name" value="{{ old('name') }}"
                            class="input w-full" placeholder="Ej. Juan Pérez" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Correo Electrónico</label>
                        <input name="email" value="{{ old('email') }}" type="email"
                            class="input w-full" placeholder="Ej. usuario@ejemplo.com" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Contraseña</label>
                        <input name="password" type="password"
                            class="input w-full" placeholder="Mínimo 8 caracteres" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Rol del Sistema</label>
                        <select name="role" class="select w-full" required>
                            <option value="user" @selected(old('role') === 'user')>User (Usuario)</option>
                            <option value="admin" @selected(old('role') === 'admin')>Admin (Administrador)</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                        <a href="{{ route('admin.dashboard') }}" class="btn-secondary btn-md">Cancelar</a>
                        <button type="submit" class="btn-primary btn-md inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Crear Cuenta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
