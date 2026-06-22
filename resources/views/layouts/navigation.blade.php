<nav class="bg-brand text-white shadow-md" x-data="{ mobileOpen: false }">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between">

      <div class="flex items-center gap-3">
        <a href="https://consultorescyc.cl" target="_blank" class="flex items-center gap-2.5">
          <img src="{{ asset('images/Logocyccorreos.png') }}" alt="C&C" class="h-9 w-auto">
          <span class="font-bold text-lg tracking-tight text-white hidden sm:block">Helpdesk C&C</span>
        </a>
      </div>

      <div class="hidden md:flex items-center gap-1">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-white/80">
          Dashboard
        </x-nav-link>

        <x-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.*')" class="text-white hover:text-white/80">
          Tickets
        </x-nav-link>

        @if(auth()->user()?->isAdmin())
          <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-white hover:text-white/80">
            Panel Admin
          </x-nav-link>
        @endif
      </div>

      <div class="flex items-center gap-3">
        <x-dropdown align="right" width="48">
          <x-slot name="trigger">
            <button class="inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium text-white hover:bg-white/10 transition-colors">
              <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
              <span class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-white/20 text-xs font-bold text-white sm:hidden">
                {{ substr(auth()->user()->name, 0, 1) }}
              </span>
              <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
              </svg>
            </button>
          </x-slot>

            <x-slot name="content">
              <div class="px-4 py-2 text-xs text-gray-400 border-b border-gray-100">
                {{ auth()->user()->email }}
              </div>
              <form method="POST" action="{{ route('logout') }}">
              @csrf
              <x-dropdown-link :href="route('logout')"
                               onclick="event.preventDefault(); this.closest('form').submit();">
                Cerrar sesión
              </x-dropdown-link>
            </form>
          </x-slot>
        </x-dropdown>

        <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-lg text-white hover:bg-white/10 transition-colors">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>

    <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="md:hidden pb-3 space-y-1">
      <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        Dashboard
      </x-responsive-nav-link>
      <x-responsive-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.*')">
        Tickets
      </x-responsive-nav-link>
      @if(auth()->user()?->isAdmin())
        <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
          Panel Admin
        </x-responsive-nav-link>
      @endif
    </div>
  </div>
</nav>
