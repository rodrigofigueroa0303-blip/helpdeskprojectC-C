<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Helpdesk C&C') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-auth min-h-screen flex flex-col">
    <header class="w-full max-w-7xl mx-auto px-6 py-4 flex justify-end">
        @if (Route::has('login'))
            <nav class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary btn-md">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-secondary btn-md">
                        Iniciar sesión
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary btn-md">
                            Registrarse
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <div class="flex-1 flex items-center justify-center px-4">
        <div class="text-center max-w-2xl animate-fade-in">
            <div class="mb-8">
                <img src="{{ asset('images/logo-cyc.png') }}" alt="C&C Consultores" class="h-16 w-auto mx-auto mb-4">
                <h1 class="text-4xl font-bold text-brand tracking-tight">Helpdesk C&C</h1>
                <p class="text-lg text-gray-500 mt-2">Sistema de soporte y gestión interna</p>
            </div>
            <div class="flex items-center justify-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary btn-lg">
                        Ir al Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary btn-lg">
                        Iniciar sesión
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-secondary btn-lg">
                            Crear cuenta
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <footer class="text-center text-xs text-gray-400 py-6">
        &copy; {{ date('Y') }} Consultores C&C — Todos los derechos reservados
    </footer>
</body>
</html>
