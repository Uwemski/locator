@props([
    'brand'       => 'Dashboard',
    'bg'          => 'bg-slate-900',      // sidebar background
    'accent'      => 'bg-blue-600',       // active-link background
    'textColor'   => 'text-slate-300',    // default link color
    'hoverBg'     => 'hover:bg-slate-800',
])

{{--
    Usage:
    <x-sidebar brand="Admin Panel" bg="bg-slate-900" accent="bg-blue-600">
        <x-nav-link href="{{ route('adminDashboard') }}" :active="request()->routeIs('adminDashboard')">
            ...icon... Dashboard
        </x-nav-link>

        <x-slot:footer>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="..." type="submit">Log out</button>
            </form>
        </x-slot:footer>
    </x-sidebar>

    Requires the "sidebar" Alpine store registered once per page (see partials.sidebar-script).
--}}

<!-- Overlay (mobile only) -->
<div
    x-show="$store.sidebar.open"
    x-transition.opacity
    @click="$store.sidebar.close()"
    class="fixed inset-0 z-30 bg-slate-900/60 lg:hidden"
    style="display: none;"
    aria-hidden="true"
></div>

<!-- Sidebar panel: always in the DOM; transform slides it off/on screen on mobile,
     and is permanently overridden to translate-x-0 from lg: up. -->
<aside
    id="app-sidebar"
    x-data
    :class="$store.sidebar.open ? 'translate-x-0' : '-translate-x-full'"
    @keydown.escape.window="$store.sidebar.close()"
    class="{{ $bg }} fixed inset-y-0 left-0 z-40 flex h-screen w-[260px] flex-col overflow-y-auto
           shadow-2xl transition-transform duration-200 ease-out
           lg:translate-x-0 lg:shadow-none"
    aria-label="Sidebar navigation"
>
    <!-- Brand -->
    <div class="flex h-16 shrink-0 items-center justify-between px-5">
        <span class="text-lg font-semibold tracking-tight text-white">{{ $brand }}</span>
        <button
            @click="$store.sidebar.close()"
            class="rounded-md p-1 text-slate-400 hover:bg-white/10 hover:text-white lg:hidden"
            aria-label="Close sidebar"
        >
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z"/>
            </svg>
        </button>
    </div>

    <!-- Nav links (passed in by caller) -->
    <nav class="flex-1 space-y-1 px-3 py-2 {{ $textColor }}">
        {{ $slot }}
    </nav>

    <!-- Footer slot (e.g. logout button) -->
    @isset($footer)
        <div class="border-t border-white/10 p-3">
            {{ $footer }}
        </div>
    @endisset
</aside>

{{-- Reserves the desktop width so content never sits under the fixed sidebar --}}
<div class="hidden lg:block lg:w-[260px] lg:shrink-0" aria-hidden="true"></div>
