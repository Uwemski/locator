<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RCCG Parish Locator Nigeria – Find a Parish Near You</title>


  <!-- Google Fonts: Playfair Display (headings) + DM Sans (body) -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    /* ── Base reset & fonts ─────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body { font-family: 'DM Sans', sans-serif; color: #1a2e20; }

    /* ── Hero gradient mesh (no image files) ────────────────── */
    .hero-bg {
      background-color: #0f4d2a;
      background-image:
        radial-gradient(ellipse 80% 60% at 15% 40%, rgba(34,136,63,0.55) 0%, transparent 65%),
        radial-gradient(ellipse 60% 80% at 85% 20%, rgba(26,107,60,0.6)  0%, transparent 60%),
        radial-gradient(ellipse 50% 50% at 50% 90%, rgba(184,148,63,0.12) 0%, transparent 60%),
        url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.025'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    /* ── Diagonal clip on hero bottom edge ──────────────────── */
    .clip-diagonal { clip-path: polygon(0 0, 100% 0, 100% 88%, 0 100%); }

    /* ── Card hover lift ────────────────────────────────────── */
    .card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .card-hover:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 40px rgba(26,107,60,0.18);
    }

    /* ── Hero staggered fade-up animations ──────────────────── */
    .hero-child-1 { animation: fadeUp 0.7s 0.10s ease both; }
    .hero-child-2 { animation: fadeUp 0.7s 0.25s ease both; }
    .hero-child-3 { animation: fadeUp 0.7s 0.40s ease both; }
    .hero-child-4 { animation: fadeUp 0.7s 0.55s ease both; }
    .hero-child-5 { animation: fadeUp 0.7s 0.70s ease both; }

    /* ── Scroll-reveal — JS adds .visible ──────────────────── */
    .reveal {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .reveal.visible { opacity: 1; transform: none; }
    .reveal-delay-1 { transition-delay: 0.10s; }
    .reveal-delay-2 { transition-delay: 0.25s; }
    .reveal-delay-3 { transition-delay: 0.40s; }
    .reveal-delay-4 { transition-delay: 0.55s; }

    /* ── Navbar: transparent → white on scroll ──────────────── */
    #navbar { transition: box-shadow 0.3s ease, background-color 0.3s ease; }
    #navbar.scrolled {
      background-color: #fff !important;
      box-shadow: 0 2px 20px rgba(26,107,60,0.12);
    }
    #navbar.scrolled .nav-link { color: #1a6b3c; }
    #navbar.scrolled .nav-logo-text { color: #1a6b3c; }
    #navbar.scrolled .nav-cta  { background-color: #1a6b3c; color: #fff; }

    /* ── Hamburger lines ────────────────────────────────────── */
    .ham-line {
      display: block; width: 22px; height: 2px;
      background: currentColor; border-radius: 2px;
      transition: transform 0.3s ease, opacity 0.3s ease;
    }

    /* ── Search input focus ring ────────────────────────────── */
    .search-input:focus { outline: none; box-shadow: 0 0 0 3px rgba(34,136,63,0.3); }

    /* ── Nigeria flag top stripe (pure CSS — no image) ──────── */
    .ng-flag-stripe {
      height: 4px;
      background: linear-gradient(90deg, #1a6b3c 33.3%, #ffffff 33.3%, #ffffff 66.6%, #1a6b3c 66.6%);
    }

    /* ── "Coming Worldwide" gold pill ───────────────────────── */
    .coming-soon-badge {
      background: linear-gradient(135deg, #b8943f, #d4af5a);
      font-size: 0.65rem;
      letter-spacing: 0.1em;
    }

    /* ── CSS-only cross helper (used throughout page) ───────── */
    /*
      Usage: wrap two <span> children inside a relative container:
        <span class="css-cross-v"></span>   ← vertical bar
        <span class="css-cross-h"></span>   ← horizontal bar
      Adjust sizes via inline styles per context.
    */
    .css-cross-v { position: absolute; border-radius: 2px; }
    .css-cross-h { position: absolute; border-radius: 2px; }

      @keyframes fadeUp {
              0%:   { 
                opacity: 0, 
                transform: translateY(28px) 
              },
              100%: { 
                opacity: 1; 
                transform: translateY(0) },
            },
      @keyframes shimmer {
              0%,100%: { 
                opacity: 1 
              },
              50%:     { 
                opacity: 0.7
               },
            },

      .animate-fade-up{ animation: fadeUp 0.7s ease both; }
      .animate-shimmer{ animation: shimmer 2.5s ease-in-out infinite; }
  </style>
</head>

<body class="bg-white text-gray-800">
<div x-data="{ open: false }">
    <button @click="open = !open" class="bg-blue-500 text-white p-2">
        Test Alpine
    </button>
    <p x-show="open" class="mt-2 text-green-600 font-bold">
        Success: Alpine.js is active!
    </p>
</div>
<!-- ═══════════════════════════════════════════════════════════
     NAVIGATION BAR
     Transparent over hero → white + shadow on scroll.
     All "Find a Parish" links point to the Leaflet map page.
     ════════════════════════════════════════════════════════════ -->
<nav id="navbar" class="fixed top-0 inset-x-0 z-50 bg-transparent">

  <x-nav.home-nav/>
</nav>


<!-- ═══════════════════════════════════════════════════════════
     HERO SECTION
     Order: RCCG identity → mission tagline → headline → search
     The search form action points to your find.parish route.
     ════════════════════════════════════════════════════════════ -->
<section class="hero-bg clip-diagonal min-h-screen flex flex-col items-center justify-center text-white px-5 pt-28 pb-44 text-center relative overflow-hidden">

  <!-- Visual depth orbs — CSS only, no images ↓ -->
  <div class="absolute top-1/3 right-10 w-80 h-80 bg-yellow-400/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
  <div class="absolute bottom-20 left-8  w-64 h-64 bg-green-400/10  rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

  <!-- ① RCCG identity marker — crosses + full church name -->
  <div class="hero-child-1 flex items-center justify-center gap-3 mb-5">
    <!-- Left decorative CSS cross -->
    <span class="relative inline-flex items-center justify-center w-6 h-6 flex-shrink-0" aria-hidden="true">
      <span class="css-cross-v bg-brand-gold w-px h-full"></span>
      <span class="css-cross-h bg-brand-gold h-px w-full" style="margin-top:-4px"></span>
    </span>
    <span class="text-brand-gold font-semibold text-xs sm:text-sm uppercase tracking-[0.2em]">
      Redeemed Christian Church of God
    </span>
    <!-- Right decorative CSS cross -->
    <span class="relative inline-flex items-center justify-center w-6 h-6 flex-shrink-0" aria-hidden="true">
      <span class="css-cross-v bg-brand-gold w-px h-full"></span>
      <span class="css-cross-h bg-brand-gold h-px w-full" style="margin-top:-4px"></span>
    </span>
  </div>

  <!-- ② Mission statement — first thing pastors/decision-makers read -->
  <p class="hero-child-2 text-white/70 text-sm sm:text-base max-w-lg mx-auto leading-relaxed mb-4">
    A church growth tool for the RCCG family — helping every seeker find their nearest parish, fast.
  </p>

  <!-- ③ Main headline -->
  <h1 class="hero-child-3 font-display font-black text-4xl sm:text-5xl md:text-6xl lg:text-7xl leading-tight max-w-4xl">
    Find an RCCG Parish
    <span class="block text-brand-green-light">Anywhere in Nigeria.</span>
  </h1>

  <!-- ④ Search form
       ─────────────────────────────────────────────────────────
       LARAVEL INTEGRATION:
         action="..." → action="{{ route('find.parish') }}"
         Add @csrf token inside the form tag
         name="name"  → already matches your existing controller
       ───────────────────────────────────────────────────────── -->
  <div id="search" class="hero-child-4 mt-10 w-full max-w-2xl">
    <form action="{{ route('find.parish') }}" method="GET">
        @csrf
      <div class="flex flex-col sm:flex-row gap-3 bg-white/10 backdrop-blur-md rounded-2xl p-3 border border-white/20 shadow-2xl">

        <!-- Location / name input -->
        <div class="flex items-center flex-1 bg-white rounded-xl px-4 gap-2">
          <!-- Inline SVG pin icon — no icon font required -->
          <svg class="w-5 h-5 text-brand-green flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/>
          </svg>
          <input
            type="text"
            name="name"
            placeholder="Search by parish name, city or state…"
            class="search-input flex-1 py-3.5 text-gray-800 bg-transparent placeholder-gray-400 text-sm sm:text-base"
            aria-label="Search for a parish by name, city or state in Nigeria"
          />
        </div>

        <button type="submit" class="bg-brand-green hover:bg-brand-green-mid text-white font-semibold px-7 py-3.5 rounded-xl transition-all duration-200 text-sm sm:text-base shadow-md hover:shadow-lg active:scale-95">
          Search
        </button>
      </div>
    </form>

    <!-- OR divider -->
    <div class="flex items-center gap-4 mt-5 max-w-xs mx-auto">
      <span class="flex-1 h-px bg-white/20"></span>
      <span class="text-white/50 text-xs uppercase tracking-widest">or</span>
      <span class="flex-1 h-px bg-white/20"></span>
    </div>

    <!--
      "Use My Location" button.
      Links to the map page — your existing "Show Nearest Parish"
      button on the map page already handles navigator.geolocation.
      You could also add ?geolocate=1 as a query param and
      auto-trigger the geolocation on page load.
    -->
    <a href="/parish-map" class="mt-4 inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/25 text-white text-sm font-medium px-5 py-3 rounded-full transition-all duration-200 group">
      <!-- GPS target — inline SVG, no icon font -->
      <svg class="w-4 h-4 group-hover:animate-shimmer" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm8.94 3c-.46-4.17-3.77-7.48-7.94-7.94V1h-2v2.06C6.83 3.52 3.52 6.83 3.06 11H1v2h2.06c.46 4.17 3.77 7.48 7.94 7.94V23h2v-2.06c4.17-.46 7.48-3.77 7.94-7.94H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z"/>
      </svg>
      Use My Current Location
    </a>
  </div>

  <!-- ⑤ Nigeria-specific stats bar -->
  <div class="hero-child-5 mt-14 flex flex-wrap justify-center gap-8 sm:gap-14 text-center">
    <div>
      <p class="font-display font-bold text-3xl text-white">1,000+</p>
      <p class="text-white/55 text-xs uppercase tracking-widest mt-1">Parishes in Nigeria</p>
    </div>
    <div class="hidden sm:block w-px bg-white/20 self-stretch"></div>
    <div>
      <p class="font-display font-bold text-3xl text-white">36+</p>
      <p class="text-white/55 text-xs uppercase tracking-widest mt-1">States &amp; FCT</p>
    </div>
    <div class="hidden sm:block w-px bg-white/20 self-stretch"></div>
    <div>
      <p class="font-display font-bold text-3xl text-white">100%</p>
      <p class="text-white/55 text-xs uppercase tracking-widest mt-1">Free to Use</p>
    </div>
  </div>

  <!-- ⑥ "Coming worldwide" teaser — remove this div when you go global -->
  <div class="hero-child-5 mt-7">
    <span class="coming-soon-badge inline-block text-white font-semibold uppercase tracking-widest px-4 py-1.5 rounded-full">
      ✦ Worldwide expansion coming soon ✦
    </span>
  </div>

</section>


<!-- ═══════════════════════════════════════════════════════════
     HOW IT WORKS
     Steps match your actual map-page flow exactly.
     ════════════════════════════════════════════════════════════ -->
<section id="how" class="py-24 bg-white px-5">
  <div class="max-w-6xl mx-auto">

    <div class="text-center mb-16 reveal">
      <p class="text-brand-green font-semibold text-sm uppercase tracking-widest mb-3">Simple &amp; Fast</p>
      <h2 class="font-display font-bold text-3xl sm:text-4xl text-gray-900">How It Works</h2>
      <p class="mt-4 text-gray-500 max-w-xl mx-auto">Three steps. No sign-up required. Works on any phone in Nigeria.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">

      <!-- Step 1 — Search -->
      <div class="card-hover reveal reveal-delay-1 relative bg-brand-green-pale border border-brand-green-light rounded-2xl p-8 text-center">
        <span class="absolute -top-4 left-1/2 -translate-x-1/2 w-8 h-8 bg-brand-green text-white text-sm font-bold rounded-full flex items-center justify-center shadow" aria-hidden="true">1</span>
        <div class="inline-flex items-center justify-center w-14 h-14 bg-brand-green/10 rounded-xl mb-5 mx-auto">
          <svg class="w-7 h-7 text-brand-green" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
          </svg>
        </div>
        <h3 class="font-display font-bold text-lg text-gray-900 mb-2">Search Your Location</h3>
        <p class="text-gray-500 text-sm leading-relaxed">
          Type a parish name, city, or state anywhere in Nigeria — or tap "Use My Location" to let the app detect you automatically.
        </p>
      </div>

      <!-- Step 2 — View on map -->
      <div class="card-hover reveal reveal-delay-2 relative bg-brand-green-pale border border-brand-green-light rounded-2xl p-8 text-center">
        <span class="absolute -top-4 left-1/2 -translate-x-1/2 w-8 h-8 bg-brand-green text-white text-sm font-bold rounded-full flex items-center justify-center shadow" aria-hidden="true">2</span>
        <div class="inline-flex items-center justify-center w-14 h-14 bg-brand-green/10 rounded-xl mb-5 mx-auto">
          <svg class="w-7 h-7 text-brand-green" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
            <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>
          </svg>
        </div>
        <h3 class="font-display font-bold text-lg text-gray-900 mb-2">View Parishes on the Map</h3>
        <p class="text-gray-500 text-sm leading-relaxed">
          See all verified RCCG parishes plotted on an interactive OpenStreetMap. Tap any marker to see the name, address, and service times.
        </p>
      </div>

      <!-- Step 3 — Get directions -->
      <div class="card-hover reveal reveal-delay-3 relative bg-brand-green-pale border border-brand-green-light rounded-2xl p-8 text-center">
        <span class="absolute -top-4 left-1/2 -translate-x-1/2 w-8 h-8 bg-brand-green text-white text-sm font-bold rounded-full flex items-center justify-center shadow" aria-hidden="true">3</span>
        <div class="inline-flex items-center justify-center w-14 h-14 bg-brand-green/10 rounded-xl mb-5 mx-auto">
          <svg class="w-7 h-7 text-brand-green" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
          </svg>
        </div>
        <h3 class="font-display font-bold text-lg text-gray-900 mb-2">Get Directions &amp; Times</h3>
        <p class="text-gray-500 text-sm leading-relaxed">
          Open Google Maps directions in one tap. See service days, times, and upcoming events — all from the parish popup card.
        </p>
      </div>
    </div>

    <!-- CTA below steps -->
    <div class="text-center mt-12 reveal">
      <a href="{{route('superPower')}}" class="inline-flex items-center gap-2 bg-brand-green text-white font-semibold px-8 py-4 rounded-full hover:bg-brand-green-mid transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 transform text-base">
        Open the Parish Map
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════════════════
     FEATURED PARISHES — Nigerian cities
     ─────────────────────────────────────────────────────────
     BLADE NOTE: swap these 4 static cards with:
       foreach (featuredParishes as parish) ... endforeach
     ════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-gray-50 px-5">
  <div class="max-w-6xl mx-auto">

    <div class="text-center mb-14 reveal">
      <p class="text-brand-green font-semibold text-sm uppercase tracking-widest mb-3">Explore</p>
      <h2 class="font-display font-bold text-3xl sm:text-4xl text-gray-900">Featured Parishes</h2>
      <p class="mt-4 text-gray-500 max-w-xl mx-auto">
        A glimpse of verified RCCG parishes across Nigeria. Your nearest church home may be just around the corner.
      </p>
    </div>

    <!-- 1 col mobile → 2 tablet → 4 desktop -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

      <!-- Parish card helper:
           CSS cross badge replaces any image/icon-font icon. -->

      <!-- Card 1 — Lagos -->
      <article class="card-hover reveal reveal-delay-1 bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col">
        <div class="h-3 bg-gradient-to-r from-brand-green to-brand-green-mid"></div>
        <div class="p-6 flex flex-col flex-1">
          <div class="flex items-start gap-3 mb-4">
            <!-- CSS-only cross badge -->
            <span class="relative inline-flex items-center justify-center w-10 h-10 bg-brand-green-light rounded-lg flex-shrink-0" aria-hidden="true">
              <span class="css-cross-v bg-brand-green w-0.5 h-5" style="margin-top:-3px"></span>
              <span class="css-cross-h bg-brand-green h-0.5 w-4" style="margin-top:-6px"></span>
            </span>
            <div>
              <h3 class="font-display font-bold text-gray-900 text-base leading-tight">House of Glory Parish</h3>
              <p class="text-brand-green text-xs font-medium mt-0.5">Ikeja, Lagos</p>
            </div>
          </div>
          <div class="mt-auto space-y-1.5 mb-5">
            <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold">Service Times</p>
            <p class="text-sm text-gray-600 flex items-center gap-2">
              <svg class="w-4 h-4 text-brand-green flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              Sun 7:00 AM &amp; 9:30 AM
            </p>
            <p class="text-sm text-gray-600 flex items-center gap-2">
              <svg class="w-4 h-4 text-brand-green flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              Wed 6:00 PM (Bible Study)
            </p>
          </div>
          <a href="/parish-map" class="block text-center bg-brand-green-pale text-brand-green font-semibold text-sm py-2.5 rounded-xl hover:bg-brand-green hover:text-white transition-all duration-200">
            View on Map →
          </a>
        </div>
      </article>

      <!-- Card 2 — Abuja -->
      <article class="card-hover reveal reveal-delay-2 bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col">
        <div class="h-3 bg-gradient-to-r from-brand-green to-brand-green-mid"></div>
        <div class="p-6 flex flex-col flex-1">
          <div class="flex items-start gap-3 mb-4">
            <span class="relative inline-flex items-center justify-center w-10 h-10 bg-brand-green-light rounded-lg flex-shrink-0" aria-hidden="true">
              <span class="css-cross-v bg-brand-green w-0.5 h-5" style="margin-top:-3px"></span>
              <span class="css-cross-h bg-brand-green h-0.5 w-4" style="margin-top:-6px"></span>
            </span>
            <div>
              <h3 class="font-display font-bold text-gray-900 text-base leading-tight">Throne of Grace Parish</h3>
              <p class="text-brand-green text-xs font-medium mt-0.5">Garki, Abuja (FCT)</p>
            </div>
          </div>
          <div class="mt-auto space-y-1.5 mb-5">
            <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold">Service Times</p>
            <p class="text-sm text-gray-600 flex items-center gap-2">
              <svg class="w-4 h-4 text-brand-green flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              Sun 8:00 AM &amp; 10:30 AM
            </p>
            <p class="text-sm text-gray-600 flex items-center gap-2">
              <svg class="w-4 h-4 text-brand-green flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              Tue 6:30 PM (Prayer Night)
            </p>
          </div>
          <a href="/parish-map" class="block text-center bg-brand-green-pale text-brand-green font-semibold text-sm py-2.5 rounded-xl hover:bg-brand-green hover:text-white transition-all duration-200">
            View on Map →
          </a>
        </div>
      </article>

      <!-- Card 3 — Port Harcourt -->
      <article class="card-hover reveal reveal-delay-3 bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col">
        <div class="h-3 bg-gradient-to-r from-brand-green to-brand-green-mid"></div>
        <div class="p-6 flex flex-col flex-1">
          <div class="flex items-start gap-3 mb-4">
            <span class="relative inline-flex items-center justify-center w-10 h-10 bg-brand-green-light rounded-lg flex-shrink-0" aria-hidden="true">
              <span class="css-cross-v bg-brand-green w-0.5 h-5" style="margin-top:-3px"></span>
              <span class="css-cross-h bg-brand-green h-0.5 w-4" style="margin-top:-6px"></span>
            </span>
            <div>
              <h3 class="font-display font-bold text-gray-900 text-base leading-tight">City of Refuge Parish</h3>
              <p class="text-brand-green text-xs font-medium mt-0.5">GRA Phase 2, Port Harcourt</p>
            </div>
          </div>
          <div class="mt-auto space-y-1.5 mb-5">
            <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold">Service Times</p>
            <p class="text-sm text-gray-600 flex items-center gap-2">
              <svg class="w-4 h-4 text-brand-green flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              Sun 9:00 AM
            </p>
            <p class="text-sm text-gray-600 flex items-center gap-2">
              <svg class="w-4 h-4 text-brand-green flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              Fri 5:30 PM (Midweek)
            </p>
          </div>
          <a href="/parish-map" class="block text-center bg-brand-green-pale text-brand-green font-semibold text-sm py-2.5 rounded-xl hover:bg-brand-green hover:text-white transition-all duration-200">
            View on Map →
          </a>
        </div>
      </article>

      <!-- Card 4 — Kano -->
      <article class="card-hover reveal reveal-delay-4 bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col">
        <div class="h-3 bg-gradient-to-r from-brand-green to-brand-green-mid"></div>
        <div class="p-6 flex flex-col flex-1">
          <div class="flex items-start gap-3 mb-4">
            <span class="relative inline-flex items-center justify-center w-10 h-10 bg-brand-green-light rounded-lg flex-shrink-0" aria-hidden="true">
              <span class="css-cross-v bg-brand-green w-0.5 h-5" style="margin-top:-3px"></span>
              <span class="css-cross-h bg-brand-green h-0.5 w-4" style="margin-top:-6px"></span>
            </span>
            <div>
              <h3 class="font-display font-bold text-gray-900 text-base leading-tight">Light of the World Parish</h3>
              <p class="text-brand-green text-xs font-medium mt-0.5">Nasarawa, Kano</p>
            </div>
          </div>
          <div class="mt-auto space-y-1.5 mb-5">
            <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold">Service Times</p>
            <p class="text-sm text-gray-600 flex items-center gap-2">
              <svg class="w-4 h-4 text-brand-green flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              Sun 8:30 AM &amp; 11:00 AM
            </p>
            <p class="text-sm text-gray-600 flex items-center gap-2">
              <svg class="w-4 h-4 text-brand-green flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              Thu 6:00 PM (Bible Study)
            </p>
          </div>
          <a href="/parish-map" class="block text-center bg-brand-green-pale text-brand-green font-semibold text-sm py-2.5 rounded-xl hover:bg-brand-green hover:text-white transition-all duration-200">
            View on Map →
          </a>
        </div>
      </article>

    </div>

    <!-- View all → full map page -->
    <div class="text-center mt-12 reveal">
      <a href="/parish-map" class="inline-flex items-center gap-2 border-2 border-brand-green text-brand-green font-semibold px-8 py-3 rounded-full hover:bg-brand-green hover:text-white transition-all duration-200">
        View All Parishes on the Map
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════════════════
     PARISH REGISTRATION CTA
     ════════════════════════════════════════════════════════════ -->
<section id="register" class="py-24 px-5 bg-brand-green relative overflow-hidden">

  <!-- Subtle grid overlay — CSS only, no image file -->
  <div class="absolute inset-0 pointer-events-none" aria-hidden="true"
    style="background-image:repeating-linear-gradient(0deg,transparent,transparent 38px,rgba(255,255,255,0.03) 38px,rgba(255,255,255,0.03) 40px),repeating-linear-gradient(90deg,transparent,transparent 38px,rgba(255,255,255,0.03) 38px,rgba(255,255,255,0.03) 40px);">
  </div>

  <div class="relative max-w-3xl mx-auto text-center">

    <!-- CSS cross in a circle — no image -->
    <div class="reveal inline-flex items-center justify-center w-16 h-16 bg-white/15 rounded-2xl mb-6 mx-auto">
      <span class="relative inline-flex items-center justify-center w-full h-full" aria-hidden="true">
        <span class="css-cross-v bg-white w-1 h-9" style="margin-top:-4px"></span>
        <span class="css-cross-h bg-white h-1 w-7" style="margin-top:-8px"></span>
      </span>
    </div>

    <h2 class="reveal font-display font-black text-3xl sm:text-4xl md:text-5xl text-white leading-tight">
      Is Your Parish Listed?
    </h2>
    <p class="reveal mt-5 text-white/75 text-base sm:text-lg max-w-xl mx-auto leading-relaxed">
      If your RCCG parish is in Nigeria and not yet on the map, register it now. Make it easy for members, guests, and seekers in your area to find you.
    </p>

    <ul class="reveal mt-8 flex flex-col sm:flex-row justify-center gap-4 sm:gap-8 text-sm text-white/80">
      <li class="flex items-center gap-2">
        <svg class="w-5 h-5 text-brand-gold flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
        Free to register
      </li>
      <li class="flex items-center gap-2">
        <svg class="w-5 h-5 text-brand-gold flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
        Quick 5-minute setup
      </li>
      <li class="flex items-center gap-2">
        <svg class="w-5 h-5 text-brand-gold flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
        Reach your community
      </li>
    </ul>

    <div class="reveal mt-10">
      <a href="{{ route('reg-test')}}" class="inline-block bg-white text-brand-green font-bold px-10 py-4 rounded-full text-base hover:bg-brand-green-light transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-0.5 transform">
        Register Your Parish →
      </a>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════════════════
     ABOUT / MISSION — for pastors & decision makers
     ════════════════════════════════════════════════════════════ -->
<x-mission/>


<!-- ═══════════════════════════════════════════════════════════
     FOOTER
     ════════════════════════════════════════════════════════════ -->
<footer class="bg-gray-900 text-gray-400 pt-16 pb-8 px-5">
  <x-footer/>
</footer>


<!-- ═══════════════════════════════════════════════════════════
     MINIMAL JAVASCRIPT
     1. Hamburger toggle
     2. Navbar scroll effect (transparent → white)
     3. Scroll-reveal via IntersectionObserver
     ════════════════════════════════════════════════════════════ -->
<script>
  /* ── 1. Hamburger toggle ─────────────────────────────────── */
  const hamburger  = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobile-menu');

  hamburger.addEventListener('click', () => {
    const isOpen = !mobileMenu.classList.contains('hidden');
    mobileMenu.classList.toggle('hidden', isOpen);

    // Animate lines into an X when open
    const lines = hamburger.querySelectorAll('.ham-line');
    if (!isOpen) {
      lines[0].style.transform = 'translateY(7px) rotate(45deg)';
      lines[1].style.opacity   = '0';
      lines[2].style.transform = 'translateY(-7px) rotate(-45deg)';
    } else {
      lines.forEach(l => { l.style.transform = ''; l.style.opacity = ''; });
    }
  });

  // Auto-close menu when any link is tapped
  mobileMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      mobileMenu.classList.add('hidden');
      hamburger.querySelectorAll('.ham-line').forEach(l => {
        l.style.transform = ''; l.style.opacity = '';
      });
    });
  });

  /* ── 2. Navbar scroll effect ─────────────────────────────── */
  const navbar = document.getElementById('navbar');
  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 60);
  });

  /* ── 3. Scroll-reveal via IntersectionObserver ───────────── */
  const revealEls = document.querySelectorAll('.reveal');
  const revealObserver = new IntersectionObserver(
    entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          revealObserver.unobserve(entry.target); // animate only once
        }
      });
    },
    { threshold: 0.15 }
  );
  revealEls.forEach(el => revealObserver.observe(el));
</script>

</body>
</html>