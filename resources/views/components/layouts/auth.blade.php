<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Auth' }} · Helpdesk C&C</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-auth" style="--bg-img: url('{{ asset('images/FondoLogin4.jpeg') }}');">
  <div class="min-h-screen grid place-items-center p-4">
    <div class="w-full max-w-md animate-fade-in">
      <div class="bg-white/95 backdrop-blur rounded-2xl shadow-elevated border border-gray-100 p-8">
        <div class="flex flex-col items-center gap-3 mb-6">
          <a href="https://consultorescyc.cl/" target="_blank" rel="noreferrer"
             class="hover:opacity-80 transition-opacity">
            <img src="{{ asset('images/logo-cyc.png') }}" class="h-8 w-auto" alt="C&C">
          </a>
          <h1 class="text-2xl font-bold text-brand tracking-tight">Helpdesk C&C</h1>
          @isset($subtitle)
            <p class="text-sm text-gray-500">{{ $subtitle }}</p>
          @endisset
        </div>

        {{ $slot }}

        <p class="mt-8 text-center text-xs text-gray-400">
          &copy; {{ now()->year }} Consultores C&C — Todos los derechos reservados
        </p>
      </div>
    </div>
  </div>
</body>
</html>
