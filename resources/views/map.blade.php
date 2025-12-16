<!DOCTYPE html>
<html>
<head>
  <title>Parish Map</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <link rel="stylesheet" href="{{asset('style.css')}}" />
  <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" type="image/x-icon" />

  <style>
     body {
      font-family: 'Montserrat', sans-serif;
      background-color: #f9f9f9;
    }

    .map-page-container {
      padding: 2rem 1rem;
      max-width: 1200px;
      margin: auto;
    }

    .search-card {
      background-color: white;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      margin-bottom: 2rem;
    }

    h2 {
      margin-bottom: 1.5rem;
      font-weight: 700;
      text-align: center;
    }

    #map { 
      height: 600px;
      width: 100%;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      margin-bottom: 4rem;
    }

    
    #nearest-parish { margin-top: 1em; font-weight: bold; }

    /* ============================
   MOBILE RESPONSIVE FIXES
   ============================ */
  @media (max-width: 767px) {

    .map-page-container {
      padding: 1rem 0.7rem;
    }

    .search-card {
      padding: 1rem;
      margin-bottom: 1.5rem;
    }

    h2 {
      font-size: 1.3rem;
      margin-bottom: 1rem;
    }

    #map {
      height: 350px !important; /* Smaller map height for mobile */
      margin-bottom: 2rem;
    }

    #nearest-btn {
      width: 100%; /* full-width button on mobile */
    }

    form.d-flex {
      flex-direction: column !important;
      align-items: stretch !important;
    }
  }

  /* Extra-small screens (older devices, small Android phones) */
  @media (max-width: 480px) {
    #map {
      height: 300px !important;
    }

    h2 {
      font-size: 1.1rem;
    }
  }
  </style>
</head>
<body>

  {{-- SOCIAL NAVBAR--}}
  @include('partials.navbar1')
  <!-- MAIN NAVBAR -->
  @include('partials.navbar2') 

  <div class="map-page-container"> 
    <!-- Search Form -->
    <div class="search-card">
      <form action="{{route('find.parish')}}" method='GET' class="d-flex flex-column flex-md-row gap-2 align-items-start align-items-md-center">
        @csrf
        <input type="text" name="name" class="form-control flex-grow-1" placeholder="Search by name, city, state" required value="{{ old('name') }}">
        <button class="btn btn-primary mt-2 mt-md-0">Search</button>
      </form>

      @if (session('error'))
        <div class="alert alert-warning mt-3">{{ session('error') }}</div>
      @endif

      @if ($errors->any())
        @foreach ($errors->all() as $err )
          <div class="alert alert-danger mt-2">{{ $err }}</div>
        @endforeach
      @endif
    </div>

  </div>

  <h2>All Parishes Map</h2>

  <div class="d-flex justify-content-center mb-3">
    <button id='nearest-btn' class='btn btn-success'>📍 Show Nearest Parish</button>
  </div>

  <div id="map"></div>

  <div id="nearest-parish"></div> <!-- FIXED: Correct ID -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      console.log('JAvascript is running!');
      const map = L.map('map').setView([9.0820, 8.6753], 10); // Lagos coords

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
      }).addTo(map);

      const parishMarkers = [];

      @foreach ($verifiedParish as $parish)
        marker = L.marker([{{ $parish->latitude }}, {{ $parish->longitude }}])
          .addTo(map)
          .bindPopup(`
            <div style="min-width: 200px; max-width: 280px; font-size: 14px;">
              <b style="font-size: 16px;">{{ $parish->name }}</b><br>
              <span style="font-size: 13px;">{{ $parish->address ?? '' }}</span><br><br>
              
              @if ($parish->services)
                @foreach ($parish->services as $service)
                  <div style="margin-bottom: 12px; padding: 8px; background: #f8f9fa; border-radius: 4px;">
                    <strong style="font-size: 14px;">{{$service->name}}</strong>
                    <div style="margin-top: 6px; padding-left: 8px; font-size: 13px;">
                      <div><strong>Time:</strong> {{$service->time}}</div>
                      <div><strong>Day:</strong> {{$service->day}}</div>
                    </div>
                  </div>
                @endforeach
              @else
                <p style="color: #6c757d; font-size: 13px; font-style: italic;">No services listed yet</p>
              @endif
              
              <a href="https://www.google.com/maps/dir/?api=1&destination={{$parish->latitude}},{{$parish->longitude}}" 
                 target="_blank" 
                 style="display: inline-block; margin: 8px 0; padding: 6px 12px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; font-size: 13px;">
                📍 Get Directions
              </a>
              
              @if ($parish->events)
                <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #dee2e6;">
                  @foreach ($parish->events as $p)
                    <p style="font-size: 13px; margin: 4px 0;">
                      Upcoming event: <a href="{{route('event.find', $p->id)}}" style="color: #007bff;">View</a>
                    </p>
                  @endforeach
                </div>
              @else
                <p style="color: #6c757d; font-size: 13px; margin-top: 8px;">No upcoming events</p>
              @endif
            </div>
          `, {
            maxWidth: 300,
            minWidth: 200
          });
          
        parishMarkers.push({ 
          lat: {{ $parish->latitude }},
          lng: {{ $parish->longitude }},
          name: "{{ $parish->name }}",
          marker: marker
        });
      @endforeach

      document.getElementById('nearest-btn').addEventListener('click', function () {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showNearestParish, handleError);
        } else {
          alert("Geolocation is not supported by your browser.");
        }
      });

      function showNearestParish(position) {
        const userLat = position.coords.latitude;
        const userLng = position.coords.longitude;

        fetch(`/nearest-parish?lat=${userLat}&lng=${userLng}`)
          .then(res => res.json())
          .then(data => {
            document.getElementById('nearest-parish').innerHTML = `
              <strong>Nearest Parish:</strong> ${data.name}<br>
              <a href="https://www.google.com/maps/dir/?api=1&destination=${data.lat},${data.lng}" target="_blank">Get Directions</a>
            `;

            // Optional: Add a special marker for nearest
            L.circleMarker([data.lat, data.lng], {
              radius: 10,
              color: 'red',
              fillColor: '#f03',
              fillOpacity: 0.5
            }).addTo(map).bindPopup(`<b>${data.name}</b><br>Nearest to you`).openPopup();
          });
      }

      function handleError(error) {
        alert("Error getting location: " + error.message);
      }
    });
  </script>

</body>
</html>
