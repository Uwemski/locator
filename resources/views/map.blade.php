<!DOCTYPE html>
<html lang="en">
<head>
  <title>Find a Parish – RCCG Parish Locator</title>

  {{-- ── External stylesheets (unchanged from original) ── --}}
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <link rel="stylesheet" href="{{asset('style.css')}}" />
  <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" type="image/x-icon" />


  {{-- ── Google Fonts: Syne (display) + Nunito (body) ── --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    /* ════════════════════════════════════════════════════
       CSS CUSTOM PROPERTIES — brand tokens
       ════════════════════════════════════════════════════ */
    :root {
      --green-900:  #0d3d22;
      --green-700:  #1a6b3c;
      --green-500:  #22883f;
      --green-200:  #bbf7d0;
      --green-50:   #f0fdf4;
      --gold:       #c9a84c;
      --gold-light: #fef3c7;
      --gray-50:    #f8fafc;
      --gray-100:   #f1f5f9;
      --gray-400:   #94a3b8;
      --gray-600:   #475569;
      --gray-700:   #334155;
      --shadow-sm:  0 1px 3px rgba(0,0,0,0.08);
      --shadow-md:  0 4px 16px rgba(0,0,0,0.10);
      --shadow-lg:  0 20px 48px rgba(13,61,34,0.18);
      --radius:     14px;
    }

    /* ════════════════════════════════════════════════════
       BASE
       ════════════════════════════════════════════════════ */
    *, *::before, *::after { box-sizing: border-box; }
    html { scroll-behavior: smooth; }

    body {
      font-family: 'Nunito', sans-serif;
      background: var(--gray-50);
      color: var(--gray-700);
      min-height: 100vh;
    }

    /* ════════════════════════════════════════════════════
       PAGE HEADER BAND
       Deep green gradient with dot-grid texture overlay
       ════════════════════════════════════════════════════ */
    .map-page-header {
      background:
        linear-gradient(135deg, var(--green-900) 0%, var(--green-700) 55%, var(--green-500) 100%);
      padding: 2.75rem 1.5rem 5.5rem;   /* large bottom → card floats up over it */
      position: relative;
      overflow: hidden;
    }

    /* Dot-grid texture — pure CSS, no image file */
    .map-page-header::before {
      content: '';
      position: absolute; inset: 0;
      background-image: radial-gradient(circle, rgba(255,255,255,0.07) 1px, transparent 1px);
      background-size: 26px 26px;
      pointer-events: none;
    }

    /* Blurred glow orb top-right */
    .map-page-header::after {
      content: '';
      position: absolute;
      top: -80px; right: -100px;
      width: 420px; height: 420px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(34,136,63,0.45) 0%, transparent 65%);
      pointer-events: none;
    }

    .map-page-header__inner {
      position: relative; z-index: 1;
      max-width: 740px;
      margin: 0 auto;
      text-align: center;
    }

    /* ── Animated pulsing location pin ── */
    .pin-icon {
      display: inline-flex;
      align-items: center; justify-content: center;
      width: 56px; height: 56px;
      background: rgba(255,255,255,0.12);
      border: 2px solid rgba(255,255,255,0.22);
      border-radius: 50%;
      margin-bottom: 1rem;
      animation: pinPulse 2.8s ease-in-out infinite;
    }
    .pin-icon svg { width: 28px; height: 28px; fill: #fff; }

    @keyframes pinPulse {
      0%,100% { transform: scale(1);    box-shadow: 0 0 0 0   rgba(255,255,255,0.3); }
      50%     { transform: scale(1.1);  box-shadow: 0 0 0 14px rgba(255,255,255,0); }
    }

    .map-page-header h1 {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: clamp(1.5rem, 4vw, 2.3rem);
      color: #fff;
      margin: 0 0 0.45rem;
      letter-spacing: -0.02em;
      /* staggered fade-up */
      animation: fadeUp 0.7s 0.05s ease both;
    }

    .map-page-header p {
      color: rgba(255,255,255,0.72);
      font-size: 0.95rem;
      margin: 0;
      animation: fadeUp 0.7s 0.18s ease both;
    }

    /* ════════════════════════════════════════════════════
       SEARCH CARD
       Negative-margin overlap with the header band
       ════════════════════════════════════════════════════ */
    .search-card-wrap {
      max-width: 820px;
      margin: -3.2rem auto 0;
      padding: 0 1rem;
      position: relative; z-index: 10;
      animation: slideUp 0.65s 0.12s cubic-bezier(0.22,1,0.36,1) both;
    }

    .search-card {
      background: #fff;
      border-radius: var(--radius);
      padding: 1.5rem 1.75rem;
      box-shadow: var(--shadow-lg);
      border: 1px solid rgba(34,136,63,0.07);
    }

    .search-card__label {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      color: var(--green-700);
      margin-bottom: 0.8rem;
      display: flex;
      align-items: center;
      gap: 0.4rem;
    }

    /* Bootstrap .form-control override */
    .search-card .form-control {
      border: 2px solid var(--gray-100);
      border-radius: 10px;
      padding: 0.72rem 1rem;
      font-family: 'Nunito', sans-serif;
      font-size: 0.95rem;
      color: var(--gray-700);
      background: var(--gray-50);
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-card .form-control:focus {
      border-color: var(--green-500);
      box-shadow: 0 0 0 3px rgba(34,136,63,0.14);
      background: #fff;
      outline: none;
    }
    .search-card .form-control::placeholder { color: var(--gray-400); }

    /* Search submit button */
    .btn-search {
      background: linear-gradient(135deg, var(--green-700), var(--green-500));
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 0.72rem 1.6rem;
      font-family: 'Nunito', sans-serif;
      font-weight: 700;
      font-size: 0.95rem;
      cursor: pointer;
      white-space: nowrap;
      transition: filter 0.2s, transform 0.2s, box-shadow 0.2s;
    }
    .btn-search:hover  { filter: brightness(1.08); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(26,107,60,0.28); }
    .btn-search:active { transform: scale(0.97); filter: brightness(0.97); }

    /* Bootstrap alert tweaks */
    .alert-warning { background:var(--gold-light); border-color:var(--gold); color:#7c5e10; border-radius:10px; font-size:0.9rem; }
    .alert-danger  { border-radius:10px; font-size:0.9rem; }

    /* ════════════════════════════════════════════════════
       MAP SECTION wrapper
       ════════════════════════════════════════════════════ */
    .map-section {
      max-width: 1100px;
      margin: 2.5rem auto 0;
      padding: 0 1rem;
      animation: slideUp 0.7s 0.28s cubic-bezier(0.22,1,0.36,1) both;
    }

    /* Title row: heading + nearest btn */
    .map-section__title-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 1rem;
      margin-bottom: 1.2rem;
    }

    .map-section__title {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 1.2rem;
      color: var(--green-900);
      margin: 0;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    /* ── "Show Nearest Parish" button ── */
    #nearest-btn {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: #fff;
      color: var(--green-700);
      border: 2px solid var(--green-200);
      border-radius: 999px;
      padding: 0.55rem 1.25rem;
      font-family: 'Nunito', sans-serif;
      font-weight: 700;
      font-size: 0.88rem;
      cursor: pointer;
      transition: all 0.25s ease;
      position: relative;
      overflow: hidden;
    }

    /* Hover fill effect via pseudo-element */
    #nearest-btn::before {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(135deg, var(--green-700), var(--green-500));
      opacity: 0;
      transition: opacity 0.25s ease;
    }
    #nearest-btn:hover              { color:#fff; border-color:transparent; transform:translateY(-2px); box-shadow:0 8px 24px rgba(26,107,60,0.25); }
    #nearest-btn:hover::before      { opacity: 1; }
    #nearest-btn > *                { position: relative; z-index: 1; }

    /* Pulsing dot when locating */
    .btn-dot {
      width: 8px; height: 8px;
      border-radius: 50%;
      background: var(--green-500);
      display: inline-block;
      transition: background 0.2s;
    }
    #nearest-btn.locating .btn-dot  { animation: dotPulse 0.75s ease-in-out infinite alternate; }
    #nearest-btn.locating           { pointer-events: none; opacity: 0.85; }
    @keyframes dotPulse {
      from { opacity:1; transform:scale(1); }
      to   { opacity:0.35; transform:scale(0.65); }
    }

    /* ── The Leaflet map container ── */
    #map {
      height: 580px;
      width: 100%;
      border-radius: var(--radius);
      box-shadow: var(--shadow-lg);
      border: 3px solid rgba(255,255,255,0.9);
      outline: 1px solid rgba(34,136,63,0.09);
      animation: mapReveal 0.9s 0.45s ease both;
    }

    @keyframes mapReveal {
      from { opacity:0; transform:scale(0.984) translateY(8px); }
      to   { opacity:1; transform:scale(1)     translateY(0); }
    }

    /* ════════════════════════════════════════════════════
       NEAREST PARISH RESULT CARD
       Animated slide-in from below when result arrives
       ════════════════════════════════════════════════════ */
    #nearest-parish {
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 1rem;
    }

    /* Injected by JS — styled via inline HTML in showNearestParish() */
    .nearest-result-card {
      background: #fff;
      border-radius: var(--radius);
      padding: 1.2rem 1.5rem;
      border-left: 5px solid var(--green-500);
      box-shadow: var(--shadow-md);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 1rem;
      margin-top: 1.5rem;
      margin-bottom: 3rem;
      animation: slideInUp 0.5s cubic-bezier(0.22,1,0.36,1) both;
    }
    @keyframes slideInUp {
      from { opacity:0; transform:translateY(18px); }
      to   { opacity:1; transform:translateY(0); }
    }

    .nearest-result-card__label {
      font-size: 0.7rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: 0.1em;
      color: var(--green-500); margin-bottom: 0.2rem;
    }
    .nearest-result-card__name {
      font-family: 'Syne', sans-serif;
      font-weight: 700; font-size: 1.05rem;
      color: var(--green-900); margin: 0;
    }
    .directions-btn {
      display: inline-flex; align-items: center; gap: 0.4rem;
      background: var(--green-700); color: #fff;
      text-decoration: none;
      padding: 0.55rem 1.25rem;
      border-radius: 999px;
      font-size: 0.85rem; font-weight: 700;
      transition: filter 0.2s, transform 0.2s;
      white-space: nowrap;
    }
    .directions-btn:hover { filter:brightness(1.1); transform:translateY(-1px); color:#fff; }

    /* ════════════════════════════════════════════════════
       LEAFLET POPUP CUSTOM STYLING
       ════════════════════════════════════════════════════ */
    .leaflet-popup-content-wrapper {
      border-radius: 14px !important;
      box-shadow: 0 8px 32px rgba(13,61,34,0.2) !important;
      border: 1px solid rgba(34,136,63,0.1) !important;
      font-family: 'Nunito', sans-serif !important;
      padding: 0 !important;
      overflow: hidden;
    }
    .leaflet-popup-content  { margin: 0 !important; }
    .leaflet-popup-tip      { background: #fff !important; }
    .leaflet-popup-close-button {
      color: #64748b !important;
      font-size: 18px !important;
      padding: 6px 8px !important;
    }

    /* ════════════════════════════════════════════════════
       SHARED KEYFRAMES
       ════════════════════════════════════════════════════ */
    @keyframes fadeUp {
      from { opacity:0; transform:translateY(20px); }
      to   { opacity:1; transform:translateY(0); }
    }
    @keyframes slideUp {
      from { opacity:0; transform:translateY(32px); }
      to   { opacity:1; transform:translateY(0); }
    }

    /* ════════════════════════════════════════════════════
       RESPONSIVE
       ════════════════════════════════════════════════════ */
    @media (max-width: 767px) {
      .map-page-header          { padding-bottom: 5rem; }
      .search-card              { padding: 1.2rem; }
      #map                      { height: 360px; }
      .map-section__title-row   { flex-direction: column; align-items: flex-start; }
      #nearest-btn              { width: 100%; justify-content: center; }
      .nearest-result-card      { flex-direction: column; }
    }

    @media (max-width: 480px) {
      #map                      { height: 300px; }
      .map-page-header h1       { font-size: 1.35rem; }
    }

    /* ── Navbar: transparent → white on scroll ──────────────── */
    #navbar { transition: box-shadow 0.3s ease, background-color 0.3s ease; }
    #navbar.scrolled {
      background-color: #fff !important;
      box-shadow: 0 2px 20px rgba(26,107,60,0.12);
    }
    #navbar.scrolled .nav-link { color: #1a6b3c; }
    #navbar.scrolled .nav-logo-text { color: #1a6b3c; }
    #navbar.scrolled .nav-cta  { background-color: #1a6b3c; color: #fff; }

    #navbar a{text-underline: none}
  </style>
</head>
<body>


<nav id="navbar" class="fixed top-0 inset-x-0 z-50 bg-transparent">

  <x-nav.home-nav/>
</nav>
  {{-- ══════════════════════════════════════
       PAGE HEADER BAND
       ══════════════════════════════════════ --}}
  <div class="map-page-header">
    <div class="map-page-header__inner">
      <div class="pin-icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/>
        </svg>
      </div>
      <h1>Find an RCCG Parish Near You</h1>
      <p>Search by name, city or state — or tap your location to find the nearest parish instantly.</p>
    </div>
  </div>


  {{-- ══════════════════════════════════════
       SEARCH CARD — floats over header
       ⚠️ All Blade directives UNCHANGED:
          route('find.parish'), @csrf,
          name="name", old('name'),
          session('error'), $errors
       ══════════════════════════════════════ --}}
  <div class="search-card-wrap">
    <div class="search-card">

      <div class="search-card__label">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
          <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
        </svg>
        Search Parishes
      </div>

      <form action="{{route('find.parish')}}" method='GET'
            class="d-flex flex-column flex-md-row gap-2 align-items-start align-items-md-center">
        @csrf
        <input
          type="text"
          name="name"
          class="form-control flex-grow-1"
          placeholder="e.g. Lagos, Abuja, House of Glory…"
          required
          value="{{ old('name') }}"
        >
        <button type="submit" class="btn-search mt-2 mt-md-0">
          Search
        </button>
      </form>

      @if (session('error'))
        <div class="alert alert-warning mt-3">{{ session('error') }}</div>
      @endif

      @if ($errors->any())
        @foreach ($errors->all() as $err)
          <div class="alert alert-danger mt-2">{{ $err }}</div>
        @endforeach
      @endif

    </div>
  </div>


  {{-- ══════════════════════════════════════
       MAP SECTION
       ══════════════════════════════════════ --}}
  <div class="map-section">

    <div class="map-section__title-row">
      <h2 class="map-section__title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" aria-hidden="true">
          <path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
        </svg>
        All Parishes Map
      </h2>

      {{-- ID="nearest-btn" preserved — JS targets this --}}
      <button id="nearest-btn" type="button" aria-label="Show nearest parish using my location">
        <span class="btn-dot" aria-hidden="true"></span>
        <span>Show Nearest Parish</span>
      </button>
    </div>

    {{-- ID="map" preserved — Leaflet binds to this --}}
    <div id="map"></div>

  </div>


  {{-- ══════════════════════════════════════
       NEAREST PARISH RESULT
       ID="nearest-parish" preserved — JS innerHTML writes here
       ══════════════════════════════════════ --}}
  <div id="nearest-parish"></div>


  {{-- ══════════════════════════════════════
       SCRIPTS (Bootstrap + Leaflet unchanged)
       ══════════════════════════════════════ --}}
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {

      /* ── Map init — coords UNCHANGED ── */
      const map = L.map('map').setView([9.0820, 8.6753], 10);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© <a href="https://openstreetmap.org">OpenStreetMap</a>'
      }).addTo(map);

      /* ── Custom branded marker icon ── */
      const greenIcon = L.divIcon({
        className: '',
        html: `<div style="
          width:28px; height:28px;
          background:linear-gradient(135deg,#1a6b3c,#22883f);
          border:3px solid #fff;
          border-radius:50% 50% 50% 0;
          transform:rotate(-45deg);
          box-shadow:0 3px 10px rgba(26,107,60,0.45);
        "></div>`,
        iconSize:    [28, 28],
        iconAnchor:  [14, 28],
        popupAnchor: [0, -32],
      });

      const parishMarkers = [];

      {{-- ════════════════════════════════════════════════
           @foreach — ALL Blade expressions UNCHANGED.
           Only popup HTML has updated styling around the
           same $parish->* variable references.
           ════════════════════════════════════════════════ --}}
      @foreach ($verifiedParish as $parish)
        var marker = L.marker(
          [{{ $parish->latitude }}, {{ $parish->longitude }}],
          { icon: greenIcon }
        )
        .addTo(map)
        .bindPopup(`
          <div style="
            min-width:210px; max-width:290px;
            font-family:'Nunito',sans-serif;
            font-size:13px;
            padding:16px 14px 12px;
          ">
            <div style="
              font-family:'Syne',sans-serif;
              font-size:15px; font-weight:800;
              color:#0d3d22; margin-bottom:3px;
            ">{{ $parish->name }}</div>

            @if($parish->address)
            <div style="color:#64748b;font-size:12px;margin-bottom:10px;">
              📍 {{ $parish->address }}
            </div>
            @endif

            @if ($parish->services)
              <div style="margin-bottom:10px;">
                @foreach ($parish->services as $service)
                  <div style="
                    margin-bottom:7px; padding:8px 10px;
                    background:#f0fdf4; border-radius:8px;
                    border-left:3px solid #22883f;
                  ">
                    <strong style="color:#1a6b3c;font-size:13px;">{{$service->name}}</strong>
                    <div style="color:#334155;font-size:12px;margin-top:3px;">
                      🕐 {{$service->time}} &nbsp;·&nbsp; 📅 {{$service->day}}
                    </div>
                  </div>
                @endforeach
              </div>
            @else
              <p style="color:#94a3b8;font-size:12px;font-style:italic;margin-bottom:10px;">
                No services listed yet
              </p>
            @endif

            <a href="https://www.google.com/maps/dir/?api=1&destination={{$parish->latitude}},{{$parish->longitude}}"
               target="_blank"
               style="
                display:inline-flex;align-items:center;gap:5px;
                padding:7px 14px; margin-bottom:10px;
                background:linear-gradient(135deg,#1a6b3c,#22883f);
                color:#fff;text-decoration:none;
                border-radius:999px;font-size:12px;font-weight:700;
               ">
              📍 Get Directions
            </a>

            @if ($parish->events)
              <div style="padding-top:10px;border-top:1px solid #e2e8f0;">
                @foreach ($parish->events as $p)
                  <p style="font-size:12px;margin:4px 0;color:#334155;">
                    🗓 Upcoming event:
                    <a href="{{route('event.find', $p->id)}}"
                       style="color:#1a6b3c;font-weight:700;">View</a>
                  </p>
                @endforeach
              </div>
            @else
              <p style="color:#94a3b8;font-size:12px;margin:0;">No upcoming events</p>
            @endif
          </div>
        `, { maxWidth: 310, minWidth: 220 });

        parishMarkers.push({
          lat:    {{ $parish->latitude }},
          lng:    {{ $parish->longitude }},
          name:   "{{ $parish->name }}",
          marker: marker
        });
      @endforeach
      {{-- ═══ END @foreach ═══ --}}


      /* ════════════════════════════════════════════════════
         GEOLOCATION — logic 100% unchanged.
         fetch() URL, data.name, data.lat, data.lng identical.
         Only the innerHTML result is styled differently.
         ════════════════════════════════════════════════════ */
      const nearestBtn = document.getElementById('nearest-btn');

      nearestBtn.addEventListener('click', function () {
        this.classList.add('locating');
        this.querySelector('span:last-child').textContent = 'Locating…';

        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showNearestParish, handleError, {
          enableHighAccuracy: true,
          timeout: 10000,
          maximumAge: 0
        });
        } else {
          alert("Geolocation is not supported by your browser.");
          resetBtn();
        }
      });

      function showNearestParish(position) {
        const userLat = position.coords.latitude;
        const userLng = position.coords.longitude;


        /** */

        L.marker([userLat, userLng])
        .addTo(map)
        .bindPopup("📍 Your location")
        .openPopup();
        /* UNCHANGED fetch call */
        fetch(`/nearest-parish?lat=${userLat}&lng=${userLng}`)
          .then(res => res.json())
          .then(data => {

            /* Styled result card — data.name / data.lat / data.lng unchanged */
            document.getElementById('nearest-parish').innerHTML = `
              <div class="nearest-result-card">
                <div>
                  <div class="nearest-result-card__label">📍 Nearest Parish Found</div>
                  <p class="nearest-result-card__name">${data.name}</p>
                </div>
                <a href="https://www.google.com/maps/dir/?api=1&destination=${data.lat},${data.lng}"
                   target="_blank"
                   class="directions-btn">
                  Get Directions →
                </a>
              </div>
            `;

            /* UNCHANGED circle marker */
            L.circleMarker([data.lat, data.lng], {
              radius: 13,
              color: '#c9a84c',
              fillColor: '#fef3c7',
              fillOpacity: 0.9,
              weight: 3,
            }).addTo(map)
              .bindPopup(`
                <div style="padding:10px 12px;font-family:'Nunito',sans-serif;">
                  <b style="font-family:'Syne',sans-serif;font-size:14px;color:#0d3d22;">${data.name}</b><br>
                  <span style="color:#64748b;font-size:12px;">Nearest to your location</span>
                </div>
              `)
              .openPopup();

            resetBtn();
          })
          .catch(() => resetBtn());
      }

      function handleError(error) {
        alert("Error getting location: " + error.message);
        resetBtn();
      }

      function resetBtn() {
        nearestBtn.classList.remove('locating');
        nearestBtn.querySelector('span:last-child').textContent = 'Show Nearest Parish';
      }

    }); // end DOMContentLoaded
  </script>

</body>
</html>