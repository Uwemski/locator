<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Register Your Parish — RCCG Locator</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=DM+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }

        #map {
            height: 420px;
        }

        .leaflet-container {
            border-radius: 1.5rem;
        }

        .form-input {
            @apply w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 outline-none transition-all duration-200;
        }

        .form-input:focus {
            border-color: #1a6b3c;
            box-shadow: 0 0 0 4px rgba(26,107,60,0.08);
        }

        .card-hover {
            transition: all .25s ease;
        }

        .card-hover:hover {
            transform: translateY(-3px);
        }
    </style>
</head>

<body class="bg-brand-green-pale text-gray-800 antialiased">

    {{-- HERO --}}
    <section class="relative overflow-hidden">

        <div class="absolute inset-0 bg-gradient-to-br from-brand-green to-brand-green-mid opacity-95"></div>

        <div class="relative max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 py-20 lg:py-28">

            <div class="max-w-3xl">

                <p class="text-brand-gold uppercase tracking-[0.25em] text-xs sm:text-sm font-semibold mb-5">
                    RCCG Parish Registration
                </p>

                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight">
                    Add Your Parish
                    <span class="text-brand-gold">To The Locator</span>
                </h1>

                <p class="mt-6 text-white/80 text-base sm:text-lg leading-relaxed max-w-2xl">
                    Help members and visitors discover your parish easily across Nigeria.
                    Pin your exact church location and provide accurate worship details.
                </p>

                <div class="flex flex-wrap gap-4 mt-8">
                    <a
                        href="#registration-form"
                        class="inline-flex items-center justify-center rounded-full bg-white text-brand-green font-semibold px-7 py-3 hover:bg-brand-green-pale transition-all duration-200"
                    >
                        Register Parish
                    </a>

                    <a
                        href="/"
                        class="inline-flex items-center justify-center rounded-full border border-white/20 text-white px-7 py-3 hover:bg-white/10 transition-all duration-200"
                    >
                        Back Home
                    </a>
                </div>

            </div>

        </div>

    </section>

    {{-- MAP + FORM --}}
    <section id="registration-form" class="py-16 sm:py-20 px-5">

        <div class="max-w-7xl mx-auto grid grid-cols-1 xl:grid-cols-2 gap-10 items-start">

            {{-- MAP CARD --}}
            <div class="bg-white rounded-[2rem] shadow-xl border border-brand-green/10 overflow-hidden">

                <div class="p-6 sm:p-8 border-b border-gray-100">

                    <div class="flex items-start justify-between gap-4">

                        <div>
                            <p class="text-brand-green font-semibold text-sm uppercase tracking-widest mb-2">
                                Location Picker
                            </p>

                            <h2 class="font-display text-3xl font-bold text-gray-900">
                                Select Parish Location
                            </h2>
                        </div>

                        <div class="w-14 h-14 rounded-2xl bg-brand-green-light flex items-center justify-center text-2xl">
                            📍
                        </div>

                    </div>

                    <p class="text-gray-500 mt-4 leading-relaxed">
                        Click anywhere on the map or use your current location to automatically
                        fill the parish coordinates.
                    </p>

                </div>

                <div class="p-6 sm:p-8">

                    <button
                        id="auto-locate"
                        type="button"
                        class="inline-flex items-center gap-2 rounded-full bg-brand-green text-white font-semibold px-6 py-3 hover:bg-brand-green-mid transition-all duration-200 shadow-lg shadow-brand-green/10"
                    >
                        📍 Use My Location
                    </button>

                    <div id="geo-error" class="text-red-500 text-sm mt-4"></div>

                    <div class="mt-6">
                        <div id="map"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">

                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">
                                Latitude
                            </label>

                            <input
                                type="text"
                                id="latitude"
                                readonly
                                class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm"
                            >
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">
                                Longitude
                            </label>

                            <input
                                type="text"
                                id="longitude"
                                readonly
                                class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm"
                            >
                        </div>

                    </div>

                </div>

            </div>

            {{-- FORM CARD --}}
            <div class="bg-white rounded-[2rem] shadow-xl border border-brand-green/10 overflow-hidden">

                <div class="p-6 sm:p-8 border-b border-gray-100">

                    <p class="text-brand-green font-semibold text-sm uppercase tracking-widest mb-2">
                        Parish Information
                    </p>

                    <h2 class="font-display text-3xl font-bold text-gray-900">
                        Create Parish Account
                    </h2>

                    <p class="text-gray-500 mt-4 leading-relaxed">
                        Enter accurate church information so members can locate your parish easily.
                    </p>

                </div>

                <div class="p-6 sm:p-8">

                    @if(session('error'))
                        <div class="mb-6 rounded-2xl border border-yellow-200 bg-yellow-50 px-5 py-4 text-yellow-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4">
                            <ul class="space-y-2 text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="/parish_reg" enctype="multipart/form-data" class="space-y-5">

                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Parish Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Enter parish name"
                                required
                                class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-brand-green"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Email Address
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Enter email"
                                required
                                class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-brand-green"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                placeholder="Create password"
                                required
                                class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-brand-green"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Parish Address
                            </label>

                            <input
                                type="text"
                                name="address"
                                value="{{ old('address') }}"
                                placeholder="Enter parish address"
                                required
                                class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-brand-green"
                            >
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    State
                                </label>

                                <select
                                    name="state"
                                    id="state"
                                    class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-brand-green"
                                >
                                    <option value="">Select State</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    City / LGA
                                </label>

                                <select
                                    name="city"
                                    id="lga"
                                    class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-brand-green"
                                >
                                    <option value="">Select City</option>
                                </select>
                            </div>

                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Country
                            </label>

                            <input
                                type="text"
                                name="country"
                                value="{{ old('country') }}"
                                placeholder="Country"
                                required
                                class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-brand-green"
                            >
                        </div>

                        <input type="hidden" name="latitude" id="latitude-hidden">
                        <input type="hidden" name="longitude" id="longitude-hidden">

                        <div class="rounded-2xl bg-brand-green-pale border border-brand-green/10 p-5">

                            <p class="text-sm text-brand-green leading-relaxed">
                                Adding a parish image helps members recognize your church faster.
                                Accepted formats: png, jpg, jpeg, webp (max 10MB).
                            </p>

                            <div class="mt-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Parish Image (Optional)
                                </label>

                                <input
                                    type="file"
                                    name="photo"
                                    id="file"
                                    class="w-full rounded-2xl border border-gray-200 px-4 py-3"
                                >
                            </div>

                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-2xl bg-gradient-to-r from-brand-green to-brand-green-mid text-white font-semibold py-4 hover:scale-[1.01] transition-all duration-200 shadow-xl shadow-brand-green/10"
                        >
                            Save Parish Location
                        </button>

                        <p class="text-center text-sm text-gray-500">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-brand-green font-semibold hover:underline">
                                Log in
                            </a>
                        </p>

                    </form>

                </div>

            </div>

        </div>

    </section>

    {{-- LEAFLET --}}
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([6.5244, 3.3792], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let marker;

        map.on('click', function(e) {

            const { lat, lng } = e.latlng;

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lng]).addTo(map);

            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);

            document.getElementById('latitude-hidden').value = lat.toFixed(6);
            document.getElementById('longitude-hidden').value = lng.toFixed(6);
        });

        document.getElementById('auto-locate').addEventListener('click', function () {

            if (navigator.geolocation) {

                navigator.geolocation.getCurrentPosition(function(position) {

                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    if (marker) map.removeLayer(marker);

                    marker = L.marker([lat, lng]).addTo(map);

                    map.setView([lat, lng], 15);

                    document.getElementById('latitude').value = lat.toFixed(6);
                    document.getElementById('longitude').value = lng.toFixed(6);

                    document.getElementById('latitude-hidden').value = lat.toFixed(6);
                    document.getElementById('longitude-hidden').value = lng.toFixed(6);

                    document.getElementById('geo-error').textContent = "";

                }, function(error) {

                    alert("Error: " + error.message);

                }, {
                    enableHighAccuracy: true,
                    timeout: 10000
                });

            } else {

                document.getElementById('geo-error').textContent =
                    "Geolocation is not supported by this browser.";
            }
        });

        fetch('/locations/states')
        .then(res => res.json())
        .then(states => {

            let stateSelect = document.getElementById('state');

            states.forEach(state => {

                let option = document.createElement('option');

                option.value = state;
                option.textContent = state;

                stateSelect.appendChild(option);
            });

        })
        .catch(err => console.log(err));

        document.getElementById('state').addEventListener('change', function() {

            let state = this.value;

            let lgaSelect = document.getElementById('lga');

            lgaSelect.innerHTML = '<option value="">-- Select LGA --</option>';

            if (state) {

                fetch(`/locations/lgas/${encodeURIComponent(state)}`)
                    .then(res => res.json())
                    .then(lgas => {

                        lgas.forEach(lga => {

                            let option = document.createElement('option');

                            option.value = lga;
                            option.textContent = lga;

                            lgaSelect.appendChild(option);
                        });

                    })
                    .catch(err => console.error(err));
            }
        });
    </script>

</body>
</html>