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
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            margin: 0;
        }

        /* Map */
        #map {
            height: 280px;
            width: 100%;
            border-radius: 1rem;
        }

        @media (min-width: 640px) {
            #map { height: 340px; }
        }

        @media (min-width: 1024px) {
            #map { height: 400px; }
        }

        .leaflet-container {
            border-radius: 1rem;
        }

        /* Form inputs */
        .form-input {
            width: 100%;
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
            background: #fff;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            color: #374151;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            -webkit-appearance: none;
            appearance: none;
        }

        .form-input:focus {
            border-color: #1a6b3c;
            box-shadow: 0 0 0 4px rgba(26,107,60,0.08);
        }

        /* Registration section layout */
        .reg-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        @media (min-width: 1024px) {
            .reg-grid {
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
                padding: 0 2rem;
            }
        }

        /* Cards */
        .reg-card {
            background: #fff;
            border-radius: 1.5rem;
            border: 1px solid rgba(26,107,60,0.1);
            box-shadow: 0 8px 32px rgba(0,0,0,0.07);
            overflow: hidden;
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f3f4f6;
        }

        @media (min-width: 640px) {
            .card-header { padding: 2rem; }
        }

        .card-body {
            padding: 1.5rem;
        }

        @media (min-width: 640px) {
            .card-body { padding: 2rem; }
        }

        /* Coord grid */
        .coord-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 1rem;
        }

        /* State + City grid */
        .state-city-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        @media (min-width: 480px) {
            .state-city-grid { grid-template-columns: 1fr 1fr; }
        }

        /* Hero */
        .hero {
            position: relative;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #1a6b3c, #2d9d63);
            opacity: 0.97;
        }

        .hero-inner {
            position: relative;
            max-width: 1280px;
            margin: 0 auto;
            padding: 3rem 1.25rem 3.5rem;
        }

        @media (min-width: 640px) {
            .hero-inner { padding: 4rem 1.5rem 5rem; }
        }

        @media (min-width: 1024px) {
            .hero-inner { padding: 5rem 2rem 6rem; }
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 700;
            color: #fff;
            line-height: 1.15;
            margin: 0 0 1rem;
        }

        .hero-eyebrow {
            color: #f5c842;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .hero-sub {
            color: rgba(255,255,255,0.82);
            font-size: clamp(0.9rem, 2.5vw, 1.05rem);
            line-height: 1.7;
            max-width: 580px;
            margin: 0 0 1.75rem;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .btn-primary-hero {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            background: #fff;
            color: #1a6b3c;
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            font-size: 0.9rem;
            text-decoration: none;
            transition: background 0.2s;
            white-space: nowrap;
        }

        .btn-primary-hero:hover { background: #f0fdf4; }

        .btn-outline-hero {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            border: 1px solid rgba(255,255,255,0.25);
            color: #fff;
            padding: 0.75rem 1.75rem;
            font-size: 0.9rem;
            text-decoration: none;
            transition: background 0.2s;
            white-space: nowrap;
        }

        .btn-outline-hero:hover { background: rgba(255,255,255,0.1); }

        /* Locate button */
        .btn-locate {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border-radius: 9999px;
            background: #1a6b3c;
            color: #fff;
            font-weight: 600;
            padding: 0.7rem 1.4rem;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
            width: 100%;
            justify-content: center;
        }

        @media (min-width: 480px) {
            .btn-locate { width: auto; }
        }

        .btn-locate:hover { background: #155c33; }

        /* Submit button */
        .btn-submit {
            width: 100%;
            border-radius: 1rem;
            background: linear-gradient(90deg, #1a6b3c, #2d9d63);
            color: #fff;
            font-weight: 600;
            padding: 1rem;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.2s;
            box-shadow: 0 8px 24px rgba(26,107,60,0.15);
        }

        .btn-submit:hover {
            opacity: 0.93;
            transform: translateY(-1px);
        }

        /* Alert boxes */
        .alert-error {
            margin-bottom: 1.25rem;
            border-radius: 1rem;
            border: 1px solid #fecaca;
            background: #fef2f2;
            padding: 1rem 1.25rem;
        }

        .alert-warning {
            margin-bottom: 1.25rem;
            border-radius: 1rem;
            border: 1px solid #fef08a;
            background: #fefce8;
            padding: 1rem 1.25rem;
            color: #854d0e;
        }

        /* Photo note */
        .photo-note {
            border-radius: 1rem;
            background: #f0fdf4;
            border: 1px solid rgba(26,107,60,0.1);
            padding: 1rem 1.25rem;
        }

        /* Label */
        .field-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        /* Section padding */
        .reg-section {
            padding: 3rem 0;
        }

        @media (min-width: 640px) {
            .reg-section { padding: 4rem 0; }
        }

        /* Readonly coord inputs */
        .coord-input {
            width: 100%;
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            color: #374151;
            outline: none;
        }

        /* Form spacing */
        .form-stack { display: flex; flex-direction: column; gap: 1.1rem; }
    </style>
</head>

<body class="bg-brand-green-pale text-gray-800 antialiased">

    {{-- HERO --}}
    <section class="hero">

        <div class="hero-bg"></div>

        <div class="hero-inner">
            <div style="max-width: 680px;">

                <p class="hero-eyebrow">RCCG Parish Registration</p>

                <h1>
                    Add Your Parish
                    <span style="color: #f5c842;">To The Locator</span>
                </h1>

                <p class="hero-sub">
                    Help members and visitors discover your parish easily across Nigeria.
                    Pin your exact church location and provide accurate worship details.
                </p>

                <div class="hero-actions">
                    <a href="#registration-form" class="btn-primary-hero">Register Parish</a>
                    <a href="/" class="btn-outline-hero">Back Home</a>
                </div>

            </div>
        </div>

    </section>

    {{-- MAP + FORM --}}
    <section id="registration-form" class="reg-section">

        <div class="reg-grid">

            {{-- MAP CARD --}}
            <div class="reg-card">

                <div class="card-header">
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem;">

                        <div>
                            <p style="color: #1a6b3c; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; margin: 0 0 0.4rem;">
                                Location Picker
                            </p>
                            <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(1.5rem, 4vw, 1.9rem); font-weight: 700; color: #111827; margin: 0;">
                                Select Parish Location
                            </h2>
                        </div>

                        <div style="flex-shrink: 0; width: 3rem; height: 3rem; border-radius: 0.75rem; background: #f0fdf4; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                            📍
                        </div>

                    </div>

                    <p style="color: #6b7280; margin: 0.9rem 0 0; line-height: 1.65; font-size: 0.9rem;">
                        Click anywhere on the map or use your current location to automatically
                        fill the parish coordinates.
                    </p>
                </div>

                <div class="card-body">

                    <button id="auto-locate" type="button" class="btn-locate">
                        📍 Use My Location
                    </button>

                    <div id="geo-error" style="color: #dc2626; font-size: 0.875rem; margin-top: 0.75rem;"></div>

                    <div style="margin-top: 1.25rem;">
                        <div id="map"></div>
                    </div>

                    <div class="coord-grid">
                        <div>
                            <label class="field-label">Latitude</label>
                            <input type="text" id="latitude" readonly class="coord-input">
                        </div>
                        <div>
                            <label class="field-label">Longitude</label>
                            <input type="text" id="longitude" readonly class="coord-input">
                        </div>
                    </div>

                </div>

            </div>

            {{-- FORM CARD --}}
            <div class="reg-card">

                <div class="card-header">
                    <p style="color: #1a6b3c; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; margin: 0 0 0.4rem;">
                        Parish Information
                    </p>
                    <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(1.5rem, 4vw, 1.9rem); font-weight: 700; color: #111827; margin: 0;">
                        Create Parish Account
                    </h2>
                    <p style="color: #6b7280; margin: 0.9rem 0 0; line-height: 1.65; font-size: 0.9rem;">
                        Enter accurate church information so members can locate your parish easily.
                    </p>
                </div>

                <div class="card-body">

                    @if(session('error'))
                        <div class="alert-warning">{{ session('error') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert-error">
                            <ul style="margin: 0; padding: 0; list-style: none; display: flex; flex-direction: column; gap: 0.35rem;">
                                @foreach ($errors->all() as $error)
                                    <li style="font-size: 0.875rem; color: #b91c1c;">• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="/parish-reg" enctype="multipart/form-data" class="form-stack">
                        @csrf

                        <div>
                            <label class="field-label">Parish Name</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Enter parish name"
                                required
                                class="form-input"
                            >
                        </div>

                        <div>
                            <label class="field-label">Email Address</label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Enter email"
                                required
                                class="form-input"
                            >
                        </div>

                        <div>
                            <label class="field-label">Password</label>
                            <input
                                type="password"
                                name="password"
                                placeholder="Create password"
                                required
                                class="form-input"
                            >
                        </div>

                        <div>
                            <label class="field-label">Parish Address</label>
                            <input
                                type="text"
                                name="address"
                                value="{{ old('address') }}"
                                placeholder="Enter parish address"
                                required
                                class="form-input"
                            >
                        </div>

                        <div class="state-city-grid">
                            <div>
                                <label class="field-label">State</label>
                                <select
                                    name="state"
                                    id="state"
                                    class="form-input"
                                    style="cursor: pointer;"
                                >
                                    <option value="">Select State</option>
                                    
                                </select>
                            </div>

                            <div>
                                <label class="field-label">City / LGA</label>
                                <select
                                    name="city"
                                    id="lga"
                                    class="form-input"
                                    style="cursor: pointer;"
                                >
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="field-label">Country</label>
                            <input
                                type="text"
                                name="country"
                                value="{{ old('country') }}"
                                placeholder="Country"
                                required
                                class="form-input"
                            >
                        </div>

                        <input type="hidden" name="latitude" id="latitude-hidden">
                        <input type="hidden" name="longitude" id="longitude-hidden">

                        <div class="photo-note">
                            <p style="font-size: 0.875rem; color: #166534; line-height: 1.6; margin: 0 0 0.9rem;">
                                Adding a parish image helps members recognise your church faster.
                                Accepted formats: png, jpg, jpeg, webp (max 10MB).
                            </p>
                            <label class="field-label">Parish Image (Optional)</label>
                            <input
                                type="file"
                                name="photo"
                                id="file"
                                accept="image/png,image/jpeg,image/webp"
                                class="form-input"
                                style="padding: 0.6rem 1rem;"
                            >
                        </div>

                        <button type="submit" class="btn-submit">
                            Save Parish Location
                        </button>

                        <p style="text-align: center; font-size: 0.875rem; color: #6b7280; margin: 0;">
                            Already have an account?
                            <a href="{{ route('login') }}" style="color: #1a6b3c; font-weight: 600; text-decoration: none;">
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
            if (marker) map.removeLayer(marker);
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
                    document.getElementById('geo-error').textContent = "Error: " + error.message;
                }, { enableHighAccuracy: true, timeout: 10000 });
            } else {
                document.getElementById('geo-error').textContent =
                    "Geolocation is not supported by this browser.";
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const stateSelect = document.getElementById('state');

            fetch('/locations/states')
            .then(res => res.json())
            .then(states => {
                console.log(states);//working at this point
            
                states.forEach(state => {
                const option = document.createElement('option');

                option.value = state;
                option.textContent = state;

                stateSelect.appendChild(option);
                });
            });

            document.getElementById('state').addEventListener('change', function () {
                const state = this.value;
                const lgaSelect = document.getElementById('lga');
                lgaSelect.innerHTML = '<option value="">-- Select LGA --</option>';

                if (state) {
                    fetch(`/locations/lgas/${encodeURIComponent(state)}`)
                        .then(res => res.json())
                        .then(lgas => {
                            lgas.forEach(lga => {
                                const option = document.createElement('option');
                                option.value = lga;
                                option.textContent = lga;
                                lgaSelect.appendChild(option);
                            });
                        })
                        .catch(err => console.error('LGA fetch error:', err));
                }
            });

});
    </script>

</body>
</html>