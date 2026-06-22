<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="font-bold text-2xl text-brand tracking-tight">
                {{ __('Nueva contraseña') }}
            </h2>
            <a href="{{ route('admin.passwords.index') }}"
               class="btn-secondary btn-sm inline-flex items-center gap-1.5 self-start sm:self-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver a la lista
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-8 animate-slide-up">
                
                <div class="mb-8 border-b border-gray-100 pb-6">
                    <h3 class="text-lg font-bold text-brand tracking-tight">Registrar Nueva Credencial</h3>
                    <p class="text-sm text-gray-500 mt-1">Ingresa los datos para la nueva cuenta del sistema. Todos los campos obligatorios deben ser completados.</p>
                </div>

                <form method="POST" action="{{ route('admin.passwords.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Tipo de Cuenta</label>
                            <select name="tipo" class="select" required>
                                <option value="">-- Seleccione --</option>
                                <option value="Cuenta de correo" @selected(old('tipo') == 'Cuenta de correo')>Cuenta de correo</option>
                                <option value="Cuenta de aplicación" @selected(old('tipo') == 'Cuenta de aplicación')>Cuenta de aplicación</option>
                                <option value="Cuenta Bitácora" @selected(old('tipo') == 'Cuenta Bitácora')>Cuenta de administración / Bitácora</option>
                                <option value="Cuenta Helpdesk" @selected(old('tipo') == 'Cuenta Helpdesk')>Cuenta Helpdesk</option>
                                <option value="Otro" @selected(old('tipo') == 'Otro')>Otro</option>
                            </select>
                            @error('tipo')
                                <p class="text-xs text-red-500 mt-1.5 pl-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Aplicación / Servicio</label>
                            <select name="aplicacion" class="select" required>
                                <option value="">-- Seleccione --</option>
                                <option value="Outlook" @selected(old('aplicacion') == 'Outlook')>Outlook</option>
                                <option value="Google Drive" @selected(old('aplicacion') == 'Google Drive')>Google Drive</option>
                                <option value="Brevo" @selected(old('aplicacion') == 'Brevo')>Brevo</option>
                                <option value="V2Network" @selected(old('aplicacion') == 'V2Network')>V2Network</option>
                                <option value="Google Correo" @selected(old('aplicacion') == 'Google Correo')>Google Correo</option>
                                <option value="Aula Virtual" @selected(old('aplicacion') == 'Aula Virtual')>Aula Virtual</option>
                                <option value="Bitacora C&C" @selected(old('aplicacion') == 'Cuenta Bitacora')>Bitácora C&C</option>
                                <option value="Otro" @selected(old('aplicacion') == 'Otro')>Otro</option>
                            </select>
                            @error('aplicacion')
                                <p class="text-xs text-red-500 mt-1.5 pl-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Estado Inicial</label>
                            <select name="estado" class="select">
                                <option value="Nuevo" @selected(old('estado') == 'Nuevo' || !old('estado'))>Nuevo</option>
                                <option value="Eliminado" @selected(old('estado') == 'Eliminado')>Eliminado</option>
                                <option value="Restringido" @selected(old('estado') == 'Restringido')>Restringido</option>
                            </select>
                            @error('estado')
                                <p class="text-xs text-red-500 mt-1.5 pl-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nombre de Usuario</label>
                            <input type="text" name="usuario"
                                   value="{{ old('usuario', auth()->user()->name) }}"
                                   class="input"
                                   placeholder="usuario">
                            @error('usuario')
                                <p class="text-xs text-red-500 mt-1.5 pl-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Correo Electrónico Asociado</label>
                            <input type="email" name="correo"
                                   value="{{ old('correo') }}"
                                   class="input"
                                   placeholder="usuario@consultorescyc.cl">
                            @error('correo')
                                <p class="text-xs text-red-500 mt-1.5 pl-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Contraseña de Acceso</label>
                            <input type="text" name="password"
                                   value="{{ old('password') }}"
                                   class="input font-mono"
                                   placeholder="Ingresa clave segura"
                                   required>
                            @error('password')
                                <p class="text-xs text-red-500 mt-1.5 pl-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Fecha de creación</label>
                            <input type="text"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-400 cursor-not-allowed select-none outline-none"
                                   value="{{ now()->format('d-m-Y') }}"
                                   readonly>
                            <p class="text-[11px] text-gray-400 mt-1 pl-1">Se generará de manera automática hoy.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Fecha de eliminación</label>
                            <input type="text"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-400 cursor-not-allowed select-none outline-none"
                                   value="—"
                                   readonly>
                            <p class="text-[11px] text-gray-400 mt-1 pl-1">Se llenará al cambiar el estado a eliminado.</p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Observaciones / Notas Adicionales</label>
                        <textarea name="observaciones" rows="4"
                                  class="input resize-none"
                                  placeholder="Detalles sobre el uso de esta cuenta, alcances de prueba, cambios de infraestructura o hosting asociados.">{{ old('observaciones') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-100 mt-8">
                        <a href="{{ route('admin.passwords.index') }}" class="btn-secondary btn-md">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-primary btn-md inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Guardar Registro
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
