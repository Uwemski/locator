<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Heading -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                Welcome to your Dashboard
                {{-- {{ auth()->user()->fullname }} --}}
            </h1>
            <p class="mt-2 text-gray-500">
                Manage parishes, users and monitor statistics.
            </p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Registered Parishes -->
            <a href="{{ route('admin.parishes.index') }}"
               class="group rounded-2xl bg-emerald-600 p-6 shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-2xl">

                <h3 class="text-lg font-semibold text-white">
                    Registered Parishes
                </h3>

                <div class="mt-6 flex items-center justify-between">
                    <p class="text-5xl font-bold text-white">
                        {{ $parishes }}
                    </p>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-10 w-10 text-white/70 group-hover:translate-x-1 transition"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Registered Users -->
            <a href="{{ route('admin.users.index') }}"
               class="group rounded-2xl bg-blue-600 p-6 shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-2xl">

                <h3 class="text-lg font-semibold text-white">
                    Registered Users
                </h3>

                <div class="mt-6 flex items-center justify-between">
                    <p class="text-5xl font-bold text-white">
                        {{ $users }}
                    </p>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-10 w-10 text-white/70 group-hover:translate-x-1 transition"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Verified Parishes -->
            <a href="{{ route('admin.parishes.verified') }}"
               class="group rounded-2xl bg-violet-600 p-6 shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-2xl">

                <h3 class="text-lg font-semibold text-white">
                    Verified Parishes
                </h3>

                <div class="mt-6 flex items-center justify-between">
                    <p class="text-5xl font-bold text-white">
                        {{ $verifiedParishes }}
                    </p>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-10 w-10 text-white/70 group-hover:translate-x-1 transition"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

        </div>

        <!-- Alerts -->
        <div class="mt-8">

            @if(session('error'))
                <div class="mb-4 rounded-lg border border-red-200 bg-red-100 p-4 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                @foreach($errors->all() as $err)
                    <div class="mb-2 rounded-lg border border-yellow-300 bg-yellow-100 p-4 text-yellow-800">
                        {{ $err }}
                    </div>
                @endforeach
            @endif

        </div>

        <!-- Search Card -->
        <div class="mt-10 max-w-xl rounded-2xl bg-white p-8 shadow-lg border border-gray-100">

            <h2 class="mb-6 text-xl font-semibold text-gray-800">
                Search Parish
            </h2>

            <form action="/admin/search" method="GET" class="space-y-5">

                <div>
                    <label class="mb-2 block font-medium text-gray-700">
                        Enter Parish Name
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ old('search') }}"
                        required
                        placeholder="Enter parish name..."
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none"
                    >

                    @error('search')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button
                    class="w-full rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white transition hover:bg-blue-700">
                    Search Parish
                </button>

            </form>

        </div>

    </div>
</x-admin-layout>