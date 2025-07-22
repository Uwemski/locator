<!DOCTYPE html>
<html>
<head>
  <title>Parish Map</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <link rel="stylesheet" href="{{asset('style.css')}}" />
  <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" type="image/x-icon" />

  <style>
    body{
      padding: .5rem;
    }

    #map { height: 500px; width: 100%; }
    #nearest-parish { margin-top: 1em; font-weight: bold; }
  </style>
</head>
<body>

  {{-- SOCIAL NAVBAR--}}
  @include('partials.navbar1')
  <!-- MAIN NAVBAR -->
  @include('partials.navbar2') 

  <div class="row d-flex justify-content-right align-items-right mt-4 mb-5"> 
    <div class="col-md-7">
      @if (session('error'))
        <div class="alert alert-warning">{{session('error')}}</div>
      @endif

      @if ($errors->any())
        @foreach ($errors->all() as $err )
            <div class="alert alert-primary">{{$err}}</div>
        @endforeach
      @endif
      <form action="{{route('find.parish')}}" method='GET'>
        @csrf
        <input type="text" name="name" class="form-control" placeholder="Search by name, city, state" required value={{old('name')}}>
        @error('name')
          <small style='color: red'>{{$message}}</small>
        @enderror
        <button class="btn btn-primary mt-3">Search</button>
      </form>
      
    </div>

  </div>

  <h2>All Parishes Map</h2>

  <button id='nearest-btn' class='btn btn-success'>📍 Show Nearest Parish</button>

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
            <b>{{ $parish->name }}</b><br>
            {{ $parish->address ?? '' }}<br>
              @if ($parish->services)
                @foreach ($parish->services as $service)
                  <ul>
                    <li>Service:{{$service->name}}: {{$service->time}} Day:{{$service->day}}</li>
                  </ul>
                @endforeach
              @else
                <p class='text-muted'>No services listed yet</p>
              @endif
            <a href="https://www.google.com/maps/dir/?api=1&destination={{$parish->latitude}},{{$parish->longitude}}" target="_blank">📍 Get Directions</a> 
            @if ($parish->events)
              <ul>
                @foreach ($parish->events as $p)
                  <p>This parish has upcoming event(s): <a href="{{route('event.find', $p->id)}}">View</a></p>
                @endforeach
              </ul>
            @else
                <p>Parish doesn't have any event coming up</p>
            @endif
          `);
          
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
