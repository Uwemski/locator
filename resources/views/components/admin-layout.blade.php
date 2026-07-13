
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard')</title>
 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
 
    @include('partials.sidebar-script')
 {{-- Alpine.js — only loaded if it isn't already bundled via app.js.
         Loading Alpine twice (once via npm/Vite, once via CDN) makes Alpine
         detect a duplicate instance and silently refuse to initialize at all,
         which breaks every @click/:class binding on the page. --}}
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            if (!window.Alpine) {
                var s = document.createElement('script');
                s.src = 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js';
                s.defer = true;
                document.head.appendChild(s);
            }
        });
    </script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
 
<body class="bg-gray-50 antialiased">
 
    <div class="lg:flex">
 
        <!-- SIDEBAR -->
        <x-sidebar brand="Admin Panel" bg="bg-slate-900" accent="bg-blue-600">
 
            <x-nav-link :href="route('adminDashboard')" :active="request()->routeIs('adminDashboard')" accent="bg-blue-600">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10 2 2 8v10h6v-6h4v6h6V8l-8-6Z"/>
                </svg>
                Dashboard
            </x-nav-link>
 
            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')" accent="bg-blue-600">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-7 8a7 7 0 0 1 14 0v1H3v-1Z"/>
                </svg>
                View Users
            </x-nav-link>
 
            <x-nav-link :href="route('admin.parishes.index')" :active="request()->routeIs('admin.parishes.index')" accent="bg-blue-600">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10 2 3 6v12h14V6l-7-4Zm-1 7h2v6H9V9Z"/>
                </svg>
                View Parish
            </x-nav-link>
 
            <x-nav-link :href="route('admin.parishes.verified')" :active="request()->routeIs('admin.parishes.verified')" accent="bg-blue-600">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.36-9.84a.75.75 0 0 0-1.2-.9L9 11.46l-1.96-1.96a.75.75 0 1 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.13-.08l3.75-5Z" clip-rule="evenodd"/>
                </svg>
                Verified Parish
            </x-nav-link>
 
            <x-nav-link :href="route('admin.parishes.unverified')" :active="request()->routeIs('admin.parishes.unverified')" accent="bg-blue-600">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm0-11a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 7Zm0 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/>
                </svg>
                Un-verified Parish
            </x-nav-link>
 
            <x-nav-link :href="route('admin.parishes.suspended')" :active="request()->routeIs('admin.parishes.suspended')" accent="bg-blue-600">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM7 9.5h6a.5.5 0 0 1 0 1H7a.5.5 0 0 1 0-1Z" clip-rule="evenodd"/>
                </svg>
                Suspended
            </x-nav-link>
 
            <x-slot:footer>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-white/5 px-3 py-2.5
                               text-sm font-medium text-slate-300 transition-colors hover:bg-red-600 hover:text-white
                               focus:outline-none focus-visible:ring-2 focus-visible:ring-white/70"
                    >
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25V5a.75.75 0 0 1-1.5 0v-.75a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75V15a.75.75 0 0 1 1.5 0v.75A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M19 10a.75.75 0 0 0-.75-.75h-8.69l2.22-2.22a.75.75 0 0 0-1.06-1.06l-3.5 3.5a.75.75 0 0 0 0 1.06l3.5 3.5a.75.75 0 1 0 1.06-1.06l-2.22-2.22h8.69A.75.75 0 0 0 19 10Z" clip-rule="evenodd"/>
                        </svg>
                        Log out
                    </button>
                </form>
            </x-slot:footer>
        </x-sidebar>
 
        <!-- MAIN COLUMN -->
        <div class="flex min-h-screen flex-1 flex-col">
 
            <x-topbar :title="$pageTitle ?? 'Dashboard'" accent="text-blue-600">
                <x-slot:logout>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-gray-50">
                            Log out
                        </button>
                    </form>
                </x-slot:logout>
            </x-topbar>
 
            <!-- PAGE CONTENT -->
            <main class="flex-1 p-4 sm:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>
</html>