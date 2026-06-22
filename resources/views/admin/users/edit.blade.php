<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-bold text-2xl text-brand tracking-tight">
        {{ __('Editar usuario') }}
      </h2>
      <a href="{{ route('admin.users.index') }}" class="btn-secondary btn-md inline-flex items-center gap-1.5">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Volver
      </a>
    </div>
  </x-slot>

  <div class="py-8">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="card p-6 animate-slide-up">

        @if ($errors->any())
          <div class="alert-error mb-4">
            <ul class="list-disc list-inside">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="grid gap-4">
          @csrf
          @method('PUT')

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nombre</label>
            <input name="name" value="{{ old('name', $user->name) }}" class="input" required>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input" required>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Rol</label>
            @php $isMe = $user->id === auth()->id(); @endphp
            <select name="role" class="select" {{ $isMe ? 'disabled' : '' }}>
              <option value="user" @selected(old('role', $user->role) === 'user')>user</option>
              <option value="admin" @selected(old('role', $user->role) === 'admin')>admin</option>
            </select>
            @if($isMe)
              <input type="hidden" name="role" value="{{ $user->role }}">
              <p class="text-xs text-gray-500 mt-1">No puedes cambiar tu propio rol.</p>
            @endif
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Password (opcional)</label>
            <input type="password" name="password" class="input" placeholder="Dejar en blanco para no cambiar">
          </div>

          <div class="flex gap-2 pt-2">
            <button class="btn-primary btn-md">Guardar</button>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary btn-md">Cancelar</a>
          </div>
        </form>

      </div>
    </div>
  </div>
</x-app-layout>
