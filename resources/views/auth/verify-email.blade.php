<x-guest-layout>
    <div class="card p-6 max-w-md mx-auto animate-fade-in">
        <div class="mb-4 text-sm text-gray-600">
            {{ __('¡Gracias por registrarte! Antes de comenzar, verifica tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar. Si no recibiste el correo, te enviaremos otro.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="alert-success mb-4">
                {{ __('Se ha enviado un nuevo enlace de verificación a la dirección de correo que proporcionaste.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button>
                    {{ __('Reenviar Correo de Verificación') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand/30 underline">
                    {{ __('Cerrar Sesión') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
