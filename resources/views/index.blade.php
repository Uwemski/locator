<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Parish Locator | Home Page</title>
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('style.css') }}" />
  
  <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" type="image/x-icon"/>
</head>
<body>

  <!-- SOCIAL NAVBAR (unchanged) -->
  @include('partials.navbar1')

  <!-- MAIN NAVBAR -->
  @include('partials.navbar2')

  <!-- HERO SECTION -->
  <header id="mainHeader">
    <div class="container hero-content text-center">
      <h1 class="hero-title">Welcome to RCCG Parish Locator</h1>
      <p class="hero-subtitle">Find a parish near you with ease and convenience</p>
      <a href="{{ route('superPower') }}" class="btn btn-warning btn-lg rounded-pill px-4 fw-bold mt-3">
        Find a Parish
      </a>
    </div>
  </header>

  <!-- OPTIONAL: Features / Intro Section -->
  <section class="section bg-light text-center">
    <div class="container">
      <h2 class="mb-4">Why Use RCCG Parish Locator?</h2>
      <div class="row justify-content-center">
        <div class="col-md-4 mb-3">
          <div class="feature-card p-4 h-100">
            <i class="bi bi-geo-alt-fill display-4 mb-3 text-primary"></i>
            <h5>Accurate Locations</h5>
            <p>Find the closest parishes to your location instantly.</p>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="feature-card p-4 h-100">
            <i class="bi bi-calendar-event-fill display-4 mb-3 text-primary"></i>
            <h5>Service Times</h5>
            <p>Check service schedules and plan your visit accordingly.</p>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="feature-card p-4 h-100">
            <i class="bi bi-map-fill display-4 mb-3 text-primary"></i>
            <h5>Directions & Maps</h5>
            <p>Get directions and navigate easily to your chosen parish.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="footer py-3 bg-dark text-light text-center">
    <div class="container">
      © {{ date('Y') }} RCCG Parish Locator. All Rights Reserved. Designed and devloped by Uffort Uwem Paul
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
