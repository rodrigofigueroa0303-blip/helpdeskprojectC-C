<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-brand tracking-tight">
            {{ __('Crear Ticket') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="alert-error mb-6 animate-fade-in">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card p-6 animate-slide-up">

                <form method="POST"
                      action="{{ route('tickets.store') }}"
                      enctype="multipart/form-data"
                      class="grid gap-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Asunto <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="subject"
                            value="{{ old('subject') }}"
                            required
                            class="input"
                            placeholder="Ej: No puedo acceder al correo"
                        >
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Departamento
                            </label>
                            <select name="department" class="select">
                                <option value="">Seleccione departamento</option>
                                @foreach($departments as $d)
                                    <option value="{{ $d }}" @selected(old('department') === $d)>
                                        {{ $d }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Categoría
                            </label>
                            <select name="category" class="select">
                                <option value="">Seleccione categoría</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c }}" @selected(old('category') === $c)>
                                        {{ $c }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Prioridad <span class="text-red-500">*</span>
                        </label>
                        <select name="priority" required class="select">
                            @foreach($priorities as $p)
                                <option value="{{ $p }}" @selected(old('priority') === $p)>
                                    {{ $p }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Describe el problema <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            name="description"
                            rows="4"
                            required
                            class="input resize-none"
                            placeholder="Ej: Desde hoy en la mañana Outlook pide contraseña y no me deja entrar…"
                        >{{ old('description') }}</textarea>
                    </div>

                    <div class="grid gap-1">
                        <label class="block text-sm font-medium text-gray-700">
                            Adjuntar archivo (opcional)
                        </label>

                        <input type="file" name="attachment" class="block w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-brand file:text-white file:hover:bg-brand-700 file:cursor-pointer transition-all">

                        <p class="text-xs text-gray-400">
                            PDF / Imágenes / DOCX / XLSX · máx 25MB
                        </p>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                        <button class="btn-primary btn-md">
                            Crear Ticket
                        </button>

                        <a href="{{ route('tickets.index') }}" class="btn-secondary btn-md">
                            Volver
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
