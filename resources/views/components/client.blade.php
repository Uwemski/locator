<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Parish Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    @include('partials.sidebar-script')

    <style>[x-cloak] { display: none !important; }

        #map {
            height:500px;
            width:100%;
        }
    </style>
</head>

<body class="bg-[#f4faf2] antialiased">

    <div class="lg:flex">

        <!-- SIDEBAR -->
        <x-sidebar brand="RCCG Parish" bg="bg-[#4c9636]" accent="bg-[#2e5d20]">

            <x-nav-link href="#" accent="bg-[#2e5d20]">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10 2 2 8v10h6v-6h4v6h6V8l-8-6Z"/>
                </svg>
                Dashboard
            </x-nav-link>

            <x-nav-link :href="route('update-profile-index')" :active="request()->routeIs('update-profile-index')" accent="bg-[#2e5d20]">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-7 8a7 7 0 0 1 14 0v1H3v-1Z"/>
                </svg>
                Edit Profile
            </x-nav-link>

            <x-nav-link :href="route('manage-location')" :active="request()->routeIs('manage-location')" accent="bg-[#2e5d20]">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18s6-5.33 6-10A6 6 0 0 0 4 8c0 4.67 6 10 6 10Zm0-8a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" clip-rule="evenodd"/>
                </svg>
                Manage Location
            </x-nav-link>

            <x-nav-link :href="route('service.create.index')" :active="request()->routeIs('service.create.index')" accent="bg-[#2e5d20]">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 0 1 1 1v1h6V3a1 1 0 1 1 2 0v1h1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1V3a1 1 0 0 1 1-1Zm-2 7v7a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 .5-.5V9H4Z" clip-rule="evenodd"/>
                </svg>
                Service Schedule
            </x-nav-link>

            <x-nav-link :href="route('service.show')" :active="request()->routeIs('service.show')" accent="bg-[#2e5d20]">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M3 5.5A2.5 2.5 0 0 1 5.5 3h9A2.5 2.5 0 0 1 17 5.5v9a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 3 14.5v-9ZM6 8h8v1.5H6V8Zm0 3h8v1.5H6V11Z" clip-rule="evenodd"/>
                </svg>
                Manage Services
            </x-nav-link>

            <x-nav-link :href="route('events')" :active="request()->routeIs('events')" accent="bg-[#2e5d20]">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 0 1 1 1v1h6V3a1 1 0 1 1 2 0v1h1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1V3a1 1 0 0 1 1-1Zm-2 7v7a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 .5-.5V9H4Z" clip-rule="evenodd"/>
                </svg>
                Events
            </x-nav-link>

            <x-nav-link :href="route('event.show')" :active="request()->routeIs('event.show')" accent="bg-[#2e5d20]">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M3 5.5A2.5 2.5 0 0 1 5.5 3h9A2.5 2.5 0 0 1 17 5.5v9a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 3 14.5v-9Zm3.5 2a.75.75 0 0 0 0 1.5h7a.75.75 0 0 0 0-1.5h-7Z"/>
                </svg>
                Manage Events
            </x-nav-link>

            <x-slot:footer>
                <form action="/parish/logout" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-white/10 px-3 py-2.5
                               text-sm font-medium text-white transition-colors hover:bg-red-600
                               focus:outline-none focus-visible:ring-2 focus-visible:ring-white/70"
                    >
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25V5a.75.75 0 0 1-1.5 0v-.75a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75V15a.75.75 0 0 1 1.5 0v.75A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M19 10a.75.75 0 0 0-.75-.75h-8.69l2.22-2.22a.75.75 0 0 0-1.06-1.06l-3.5 3.5a.75.75 0 0 0 0 1.06l3.5 3.5a.75.75 0 1 0 1.06-1.06l-2.22-2.22h8.69A.75.75 0 0 0 19 10Z" clip-rule="evenodd"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </x-slot:footer>
        </x-sidebar>

        <!-- MAIN COLUMN -->
        <div class="flex min-h-screen flex-1 flex-col">

            <x-topbar :title="$pageTitle ?? 'Welcome, Parish Admin'" accent="text-[#4c9636]">
                <x-slot:logout>
                    <form action="/parish/logout" method="POST">
                        @csrf
                        <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-gray-50">
                            Logout
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
</body>
</html>
