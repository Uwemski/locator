<!DOCTYPE html>
<html>
<head>
    <title>Register Parish with Location</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        #map {
            height: 400px;
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h2>Parish Registration</h2>

<div class="container">
    <h2>Register Parish</h2>

    <form method="POST" action="">
        @csrf

        <button type="button" id="getLocationBtn" class="btn btn-primary mb-3">Use My Location</button>
        <div id="map" style="height: 400px;" class="mb-3"></div>

        <input type="hidden" name="Latitude" id="latitude">
        <input type="hidden" name="Longitude" id="longitude">

        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" id="address" class="form-control" required>
        </div>

        <div class="form-group">
            <label>City</label>
            <input type="text" name="city" id="city" class="form-control" required>
        </div>

        <div class="form-group">
            <label>State</label>
            <input type="text" name="state" id="state" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Country</label>
            <input type="text" name="country" id="country" class="form-control" required>
        </div>

        <!-- Add other fields like name, pastor_name, etc. -->

        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>

<!-- Leaflet & Nominatim scripts -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
let map = L.map('map').setView([0, 0], 2);
let marker;

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Click to place pin
map.on('click', function(e) {
    setMarkerAndReverseGeocode(e.latlng.lat, e.latlng.lng);
});

document.getElementById('getLocationBtn').addEventListener('click', function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            let lat = position.coords.latitude;
            let lng = position.coords.longitude;
            setMarkerAndReverseGeocode(lat, lng);
            map.setView([lat, lng], 18);
        }, function() {
            alert("Unable to access your location.");
        });
    } else {
        alert("Geolocation is not supported.");
    }
});

function setMarkerAndReverseGeocode(lat, lng) {
    if (marker) map.removeLayer(marker);
    marker = L.marker([lat, lng], { draggable: true }).addTo(map);

    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;

    reverseGeocode(lat, lng);

    marker.on('dragend', function(e) {
        let pos = marker.getLatLng();
        document.getElementById('latitude').value = pos.lat;
        document.getElementById('longitude').value = pos.lng;
        reverseGeocode(pos.lat, pos.lng);
    });
}

function reverseGeocode(lat, lng) {
    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
        .then(res => res.json())
        .then(data => {
            if (data.address) {
                document.getElementById('address').value = data.address.road || '';
                document.getElementById('city').value = data.address.city || data.address.town || data.address.village || '';
                document.getElementById('state').value = data.address.state || '';
                document.getElementById('country').value = data.address.country || '';
            }
        });
}
</script>

</body>
</html>
