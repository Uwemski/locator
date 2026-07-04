@props([
    'accent' => 'text-blue-600',
])

{{--
    Usage:
    <x-topbar :title="$pageTitle ?? 'Dashboard'" accent="text-blue-600">
        <x-slot:user>
            <span class="text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
        </x-slot:user>
        <x-slot:logout>
            <form action="{{ route('admin.logout') }}" method="POST">@csrf<button>Log out</button></form>
        </x-slot:logout>
    </x-topbar>
--}}

<header class="sticky top-0 z-20 flex h-16 items-center gap-4 border-b border-gray-200 bg-white px-4 sm:px-6">

    <!-- Hamburger (mobile only) -->
    <button
        x-data
        @click="$store.sidebar.toggle()"
        class="-ml-1 rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700
               focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-300 lg:hidden"
        aria-label="Toggle sidebar"
        :aria-expanded="$store.sidebar.open"
    >
        <svg class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M2 4.75A.75.75 0 0 1 2.75 4h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 4.75Zm0 5A.75.75 0 0 1 2.75 9h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 9.75Zm0 5a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"/>
        </svg>
    </button>

    <!-- Page title -->
    <h1 class="truncate text-base font-semibold text-gray-900 sm:text-lg">
        {{ $title ?? 'Dashboard' }}
    </h1>

    <!-- Search (desktop only) -->
    @isset($search)
        <div class="ml-4 hidden flex-1 max-w-md lg:block">
            {{ $search }}
        </div>
    @else
        <div class="ml-4 hidden flex-1 max-w-md lg:block">
            <div class="relative">
                <svg class="pointer-events-none absolute left-3 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd"/>
                </svg>
                <input
                    type="search"
                    placeholder="Search..."
                    class="w-full rounded-lg border border-gray-200 bg-gray-50 py-2 pl-9 pr-3 text-sm
                           placeholder:text-gray-400 focus:border-transparent focus:outline-none focus:ring-2 {{ str_replace('text-', 'ring-', $accent) }}"
                >
            </div>
        </div>
    @endisset

    <div class="ml-auto flex items-center gap-3">

        <!-- Notification bell -->
        <button
            class="relative rounded-full p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700
                   focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-300"
            aria-label="Notifications"
        >
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M10 2a6 6 0 0 0-6 6v2.586l-.707.707A1 1 0 0 0 4 13h12a1 1 0 0 0 .707-1.707L16 10.586V8a6 6 0 0 0-6-6Zm0 16a2.5 2.5 0 0 0 2.45-2h-4.9A2.5 2.5 0 0 0 10 18Z"/>
            </svg>
            <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
        </button>

        <!-- User dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button
                @click="open = !open"
                @click.outside="open = false"
                @keydown.escape.window="open = false"
                class="flex items-center gap-2 rounded-full p-1 pr-2 hover:bg-gray-100
                       focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-300"
                :aria-expanded="open"
                aria-haspopup="true"
            >
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-200 text-sm font-semibold text-gray-700">
                    {{ isset($user) ? '' : strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </span>
                @isset($user)
                    <span class="hidden sm:block">{{ $user }}</span>
                @endisset
                <svg class="hidden h-4 w-4 text-gray-400 sm:block" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/>
                </svg>
            </button>

            <div
                x-show="open"
                x-transition.opacity.duration.150ms
                x-cloak
                class="absolute right-0 z-30 mt-2 w-48 rounded-lg border border-gray-100 bg-white py-1 shadow-lg"
            >
                @isset($menu)
                    {{ $menu }}
                @endisset

                @isset($logout)
                    <div class="border-t border-gray-100 pt-1">
                        {{ $logout }}
                    </div>
                @endisset
            </div>
        </div>
    </div>
</header>
