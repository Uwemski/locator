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
    <button id="auto-locate" class="btn btn-primary mb-2">📍 Use My Location</button>
    <div id="geo-error" class="text-danger mb-2"></div>
    <div id="map"></div>

    @if(session('error'))
        <div class="alert alert-warning">{{session('error')}}</div>
    @endif

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
            <form method="POST" action="/parish_reg" enctype="multipart/form-data">
                @csrf

                <input type="text" name="name" placeholder="Parish Name" required class="form-control" value={{old('name')}}>
                @error('name')
                    <small style='color:red'>{{$message}}</small>
                @enderror
                <input type="email" name="email" placeholder="Email" required class="form-control" value={{old('email')}}>
                @error('email')
                    <small style='color:red'>{{$message}}</small>
                @enderror
                <input type="password" name="password" placeholder="Password" required class="form-control">
                <input type="text" name="address" placeholder="Address" required class="form-control" value={{old('address')}}>
                @error('address')
                    <small style='color:red'>{{$message}}</small>
                @enderror
                 <label for="state">State</label>
                 <select name="state" id="state" class="form-select">
                    <option value=""><!----></option>
                 </select>
                @error('state')
                    <small style='color:red'>{{$message}}</small>
                @enderror
               
                 <label for="lga">City</label>
                 <select name="city" id="lga" class="form-select">
                    <option value=""><!--selected city--></option>
                 </select>
                @error('city')
                    <small style='color:red'>{{$message}}</small>
                @enderror
                <input type="text" name="country" placeholder="Country" required class="form-control" value={{old('country')}}>
                @error('country')
                    <small style='color:red'>{{$message}}</small>
                @enderror

                <input type="text" name="latitude" id="latitude" readonly placeholder="Latitude" readonly class="form-control" value={{old('latitude')}}>
                @error('latitude')
                    <small style="color:red">{{$message}}</small>
                @enderror
                <input type="text" name="longitude" id="longitude" readonly placeholder="Longitude" readonly class="form-control" value={{old('longitude')}}>
                @error('longitude')
                    <small style="color: red">{{$message}}</small>
                @enderror
                
                <small style="color:red">Adding a parish photo helps members recognize your church faster.Accepted formats: png,jpg,webp, jpeg. Max:10mb</small><br>
                <label for="file">Parish Image(optional)</label>
                <input type="file" name="photo" id="file" class='form-control'>
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

         // Handle "Use My Location" button
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
                    document.getElementById('geo-error').textContent = "";
                }, function(error) {
                    //document.getElementById('geo-error').textContent = "Unable to retrieve your location.";
                    alert("Error: "+ error.message);
                },
                {
                    enableHighAccuracy: true,timeout: 10000
                }
            );
            } else {
                document.getElementById('geo-error').textContent = "Geolocation is not supported by this browser.";
            }
        });

        // load states (on DOMContentLoaded)
        fetch('/locations/states')
        .then(res => res.json())
        .then(states => {
            let stateSelect = document.getElementById('state');
            states.forEach(state => {
                let option = document.createElement('option');
                option.value = state;
                option.textContent = state;
                stateSelect.appendChild(option);
            });
        })
        .catch(err => console.log(err));

    // When user selects a state, fetch LGAs
    document.getElementById('state').addEventListener('change', function() {
        let state = this.value;
        let lgaSelect = document.getElementById('lga');

        // reset LGAs
        lgaSelect.innerHTML = '<option value="">-- Select LGA --</option>';

        if (state) {
            fetch(`/locations/lgas/${encodeURIComponent(state)}`)
                .then(res => res.json())
                .then(lgas => {
                    lgas.forEach(lga => {
                        let option = document.createElement('option');
                        option.value = lga;
                        option.textContent = lga;
                        lgaSelect.appendChild(option);
                    });
                })
                .catch(err => console.error(err));
        }
    });
    </script>
</body>
</html>