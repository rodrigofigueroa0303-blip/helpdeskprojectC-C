<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Helpdesk C&C</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen bg-auth flex items-center justify-center p-4" style="--bg-img: url('{{ asset('images/FondoLogin4.jpeg') }}');">
    <div class="w-full max-w-md animate-fade-in">
        <div class="bg-white/95 backdrop-blur rounded-2xl shadow-elevated border border-gray-100 p-8">
            <div class="text-center mb-8">
                <a href="https://consultorescyc.cl/" target="_blank" title="Ir al sitio Consultores C&C">
                    <img src="{{ asset('images/logo-cyc.png') }}" 
                        alt="C&C Consultores" 
                        class="h-12 w-auto mx-auto mb-4 hover:opacity-80 transition-opacity">
                </a>
                <h1 class="text-2xl font-bold text-brand tracking-tight">Helpdesk C&C</h1>
                <p class="text-sm text-gray-500 mt-1">Sistema de soporte y gestión interna</p>
            </div>

            @if (session('status'))
                <div class="alert-success mb-4">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5" for="email">
                        Correo electrónico
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="input"
                        placeholder="tu@correo.cl">
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5" for="password">
                        Contraseña
                    </label>
                    <input id="password" type="password" name="password" required
                        class="input"
                        placeholder="••••••••">
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-brand focus:ring-brand/30">
                        Recuérdame
                    </label>
                </div>

                <button type="submit" class="btn-primary btn-lg w-full">
                    Iniciar sesión
                </button>
            </form>

            <p class="text-center text-xs text-gray-400 mt-8">
                &copy; {{ date('Y') }} Consultores C&C - Todos los derechos reservados
            </p>
        </div>
    </div>
</body>
</html>
