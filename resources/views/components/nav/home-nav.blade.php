<!-- Order your soul. Reduce your wants. - Augustine -->
<!-- ═══════════════════════════════════════════════════════════
     NAVIGATION BAR
     Transparent over hero → white + shadow on scroll.
     All "Find a Parish" links point to the Leaflet map page.
     ════════════════════════════════════════════════════════════ -->
 <div class="max-w-7xl mx-auto px-5 sm:px-8">
    <div class="flex items-center justify-between h-16">

      <!-- ── Brand / Logo (text + CSS cross — zero images) ── -->
      <a href="/" class="flex items-center gap-2.5 no-underline group" aria-label="RCCG Parish Locator home">

        <!--
          CSS-only cross mark.
          Two <span> elements absolutely positioned inside
          a relative container — no SVG, no icon font, no image.
        -->
        <span class="relative inline-flex items-center justify-center w-9 h-9 bg-white/15 rounded-lg border border-white/25 flex-shrink-0 group-[.scrolled]:bg-brand-green-pale group-[.scrolled]:border-brand-green-light transition-colors" aria-hidden="true">
          <span class="css-cross-v bg-white w-0.5 h-5" style="margin-top:-3px"></span>
          <span class="css-cross-h bg-white h-0.5 w-4" style="margin-top:-6px"></span>
        </span>

        <!-- RCCG text stacked above "Parish Locator" -->
        <span class="flex flex-col leading-none nav-logo-text text-white transition-colors">
          <span class="font-display font-black text-base tracking-[0.15em]">RCCG</span>
          <span class="font-body font-light text-[11px] tracking-wider opacity-80">Parish Locator</span>
        </span>
      </a>

      <!-- ── Desktop navigation links ── -->
      <div class="hidden md:flex items-center gap-6">
        <a href="{{route('home') }}"               class="nav-link text-white/85 hover:text-white text-sm font-medium transition-colors">Home</a>
        <!-- Direct link to the Leaflet map page -->
        <a href="{{route('superPower') }}"     class="nav-link text-white/85 hover:text-white text-sm font-medium transition-colors">Find a Parish</a>
        <a href="{{route('reg-test') }}"       class="nav-link text-white/85 hover:text-white text-sm font-medium transition-colors">Register a Parish</a>
        <a href="#how"            class="nav-link text-white/85 hover:text-white text-sm font-medium transition-colors">How It Works</a>
        <a href="#about"          class="nav-link text-white/85 hover:text-white text-sm font-medium transition-colors">About</a>
        <!-- Primary CTA — goes straight to map page -->
        <a href="{{route('superPower') }}" class="nav-cta ml-1 px-4 py-2 bg-white text-brand-green text-sm font-semibold rounded-full hover:bg-brand-green-light transition-all duration-200 shadow-sm whitespace-nowrap">
          Find a Parish Near Me
        </a>
      </div>

      <!-- ── Mobile hamburger button ── -->
      <button id="hamburger" aria-label="Toggle navigation menu" class="md:hidden flex flex-col gap-1.5 p-2 text-white">
        <span class="ham-line"></span>
        <span class="ham-line"></span>
        <span class="ham-line"></span>
      </button>
    </div>
  </div>

  <!-- ── Mobile dropdown menu ── -->
  <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 shadow-xl">
    <div class="max-w-7xl mx-auto px-5 py-4 flex flex-col gap-1">
      <a href="/"               class="text-brand-green font-medium py-2 px-3 rounded-lg hover:bg-brand-green-pale transition-colors">Home</a>
      <a href="/parish-map"     class="text-gray-700 font-medium py-2 px-3 rounded-lg hover:bg-brand-green-pale transition-colors">Find a Parish</a>
      <a href="#register"       class="text-gray-700 font-medium py-2 px-3 rounded-lg hover:bg-brand-green-pale transition-colors">Register a Parish</a>
      <a href="#how"            class="text-gray-700 font-medium py-2 px-3 rounded-lg hover:bg-brand-green-pale transition-colors">How It Works</a>
      <a href="#about"          class="text-gray-700 font-medium py-2 px-3 rounded-lg hover:bg-brand-green-pale transition-colors">About</a>
      <!-- CTA in mobile menu → map page -->
      <a href="/parish-map" class="mt-3 text-center bg-brand-green text-white font-semibold py-3 px-5 rounded-full hover:bg-brand-green-mid transition-colors shadow">
        📍 Find a Parish Near Me
      </a>
    </div>
  </div>