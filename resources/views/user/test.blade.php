<!DOCTYPE html>
<html>
<head>
  <title>Pick Your Parish Location</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

  <!-- Leaflet Geosearch CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.1.0/dist/geosearch.css" />

  <style>
    #map {
      height: 500px;
      width: 100%;
      margin-bottom: 1em;
    }

    .leaflet-control-locate {
      background: white;
      padding: 6px;
      border-radius: 4px;
      cursor: pointer;
    }

    body {
      font-family: Arial, sans-serif;
      padding: 1em;
      max-width: 800px;
      margin: auto;
    }
  </style>
</head>
<body>

  <h2>Register Parish Location</h2>

  <div id="map"></div>

  <button id="locateBtn" class="leaflet-control-locate">📍 Use My Location</button>

  <form id="parish-form">
    <input type="hidden" id="latitude" name="latitude" />
    <input type="hidden" id="longitude" name="longitude" />
    <button type="submit">Submit</button>
  </form>

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <!-- Leaflet GeoSearch -->
  <script src="https://unpkg.com/leaflet-geosearch@3.1.0/dist/bundle.min.js"></script>

  <script>
    const defaultLat = 6.5244;
    const defaultLng = 3.3792;

    const map = L.map('map').setView([defaultLat, defaultLng], 17); // Start zoomed in

    // Detailed Map Tiles
    L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
      maxZoom: 20,
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Draggable Marker
    const marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    function updateCoords(lat, lng) {
      latInput.value = lat;
      lngInput.value = lng;
    }

    // Initial values
    updateCoords(defaultLat, defaultLng);

    marker.on('dragend', function(e) {
      const { lat, lng } = marker.getLatLng();
      updateCoords(lat, lng);
    });

    // Locate Button Click
    document.getElementById('locateBtn').addEventListener('click', function() {
      map.locate({ setView: true, maxZoom: 19 });
    });

    map.on('locationfound', function(e) {
      marker.setLatLng(e.latlng);
      updateCoords(e.latlng.lat, e.latlng.lng);
    });

    map.on('locationerror', function() {
      alert('Location access denied or not available.');
    });

    // Add search control
    const provider = new window.GeoSearch.OpenStreetMapProvider();

    const searchControl = new window.GeoSearch.GeoSearchControl({
      provider: provider,
      style: 'bar',
      autoComplete: true,
      autoCompleteDelay: 250,
      showMarker: false,
      retainZoomLevel: false,
      animateZoom: true,
      searchLabel: 'Search address...',
      keepResult: true,
      updateMap: true
    });

    map.addControl(searchControl);

    map.on('geosearch/showlocation', function(result) {
      const { x: lng, y: lat } = result.location;
      marker.setLatLng([lat, lng]);
      updateCoords(lat, lng);
      map.setView([lat, lng], 19);
    });
  </script>

</body>
</html>
