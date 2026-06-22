<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="font-bold text-2xl text-brand tracking-tight">
                {{ __('Editar contraseña') }}
            </h2>
            <a href="{{ route('admin.passwords.index') }}"
               class="btn-secondary btn-sm inline-flex items-center gap-1.5 self-start sm:self-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver a la lista
            </a>
        </div>
    </x-slot>

    @php
        $tipos = ['Cuenta de correo', 'Cuenta de aplicación', 'Cuenta Bitácora', 'Cuenta Helpdesk', 'Otro'];
        $aplicaciones = ['Outlook', 'Google Drive', 'Brevo', 'V2NETWORKS', 'Google Correo', 'Aula Virtual', 'Bitácora C&C', 'Otro'];
        $estados = ['Nuevo', 'Eliminado', 'Restringido', 'De baja'];
    @endphp

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-8 animate-slide-up">
                
                <div class="mb-8 border-b border-gray-100 pb-6">
                    <h3 class="text-lg font-bold text-brand tracking-tight">Detalles de la Credencial</h3>
                    <p class="text-sm text-gray-500 mt-1">Modifica los campos necesarios. Recuerda que la contraseña es sensible.</p>
                </div>

                <form method="POST" action="{{ route('admin.passwords.update', $entry) }}" class="space-y-6">
                    @csrf 
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Tipo de Cuenta</label>
                            <select name="tipo" class="select" required>
                                <option value="" disabled>Selecciona un tipo</option>
                                @foreach($tipos as $t)
                                    <option value="{{ $t }}" @selected($entry->tipo === $t)>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Aplicación / Servicio</label>
                            <select name="aplicacion" class="select" required>
                                <option value="" disabled>Selecciona aplicación</option>
                                @foreach($aplicaciones as $a)
                                    <option value="{{ $a }}" @selected($entry->aplicacion === $a)>{{ $a }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Estado Actual</label>
                            <select name="estado" class="select" required>
                                @foreach($estados as $e)
                                    <option value="{{ $e }}" @selected($entry->estado === $e)>{{ $e }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nombre de Usuario</label>
                            <input name="usuario" type="text"
                                   class="input"
                                   value="{{ old('usuario', $entry->usuario) }}" placeholder="Ej: admin_cyc">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Correo Electrónico Asociado</label>
                            <input name="correo" type="email"
                                   class="input"
                                   value="{{ old('correo', $entry->correo) }}" placeholder="Ej: contacto@consultorescyc.cl">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                                Nueva Contraseña
                            </label>
                            <input name="password" type="text"
                                   class="input font-mono bg-gray-50"
                                   placeholder="(Dejar en blanco para NO cambiar)">
                            <p class="text-[11px] text-gray-400 mt-1 pl-1">Solo rellena este campo si deseas actualizar la clave.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Fecha de creación</label>
                            <input name="fecha_creacion" type="date"
                                   class="input"
                                   value="{{ old('fecha_creacion', $entry->fecha_creacion) }}">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Fecha de eliminación</label>
                            <input name="fecha_eliminacion" type="date"
                                   class="input"
                                   value="{{ old('fecha_eliminacion', $entry->fecha_eliminacion) }}">
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Observaciones / Notas Adicionales</label>
                        <textarea name="observaciones" rows="4"
                                  class="input resize-none"
                                  placeholder="Detalles sobre el uso de esta cuenta, quién tiene acceso, etc.">{{ old('observaciones', $entry->observaciones) }}</textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-100 mt-8">
                        <a href="{{ route('admin.passwords.index') }}" class="btn-secondary btn-md">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-primary btn-md inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Actualizar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
