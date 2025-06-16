<!DOCTYPE html>
<html>
<head>
    <title>Location Picker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map { height: 400px; }
        input { width: 100%; padding: 8px; margin-top: 10px; }
    </style>
</head>
<body>

    <h2>Select a location on the map</h2>
    <div id="map"></div>


    @if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <div class="container-fluid d-flex justify-contents-center vh-90 mt-3"  >
        <div class="shaded rounded mx-auto border p-5">
            <form method="POST" action="/parish_reg">
                @csrf

                <input type="text" name="name" placeholder="Parish Name" required class="form-control">
                <input type="email" name="email" placeholder="Email" required class="form-control">
                <input type="password" name="password" placeholder="Password" required class="form-control">
                <input type="text" name="address" placeholder="Address" required class="form-control">
                <input type="text" name="city" placeholder="City" required class="form-control">
                <input type="text" name="state" placeholder="State" required class="form-control">
                <input type="text" name="country" placeholder="Country" required class="form-control">




                <input type="text" name="latitude" id="latitude" placeholder="Latitude" readonly class="form-control">
                <input type="text" name="longitude" id="longitude" placeholder="Longitude" readonly class="form-control">
                <button type="submit" class="btn btn-success mt-2">Save Location</button>
                
                <p>Already have an account?<a href="{{route('login')}}">Log in </a></p>
            </form>
        </div>
    </div>
    

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([6.5244, 3.3792], 13); // Default to Lagos, Nigeria

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '©️ OpenStreetMap contributors'
        }).addTo(map);

        let marker;

        // Handle map click
        map.on('click', function(e) {
            const { lat, lng } = e.latlng;

            // Remove previous marker
            if (marker) {
                map.removeLayer(marker);
            }

            // Add new marker
            marker = L.marker([lat, lng]).addTo(map);

            // Fill form inputs
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
        });
    </script>
</body>
</html>