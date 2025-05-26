<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Parish - Google Maps API Demo</title>

    <!-- Bootstrap (optional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>

    <style>
      #map {
        height: 400px;
        width: 100%;
        margin-bottom: 15px;
      }
    </style>
    {{-- Load Google Maps JS API asynchronously with callback --}}
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
    
  </head>

  <body class="p-4">
    <h2>Register Parish</h2>

    <!-- Autocomplete input -->
    <input id="autocomplete" class="form-control mb-3" placeholder="Start typing address..." type="text"
    />

    <!-- Map container -->
    <div id="map" class="mb-3"></div>

    <!-- Form -->
    <form method="POST" action="">
      @csrf

      <!-- Hidden coords -->
      <input type="hidden" name="latitude" id="latitude" />
      <input type="hidden" name="longitude" id="longitude" />

      <!-- Address parts -->
      <div class="mb-2">
        <label for="address" class="form-label">Address</label>
        <input type="text" name="address" id="address" class="form-control" required/>
      </div>
      <div class="mb-2">
        <label for="city" class="form-label">City</label>
        <input type="text" name="city" id="city" class="form-control" required/>
      </div>
      <div class="mb-2">
        <label for="state" class="form-label">State</label>
        <input type="text"name="state" id="state" class="form-control" required/>
      </div>
      <div class="mb-4">
        <label for="country" class="form-label">Country</label>
        <input type="text" name="country" id="country" class="form-control" required/>
      </div>

      <button type="submit" class="btn btn-success">Submit</button>
    </form>


    {{-- Load Google Maps JS API asynchronously with callback --}}
    {{-- <script
      async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script> --}}
    <script>
      let map, marker, autocomplete;

      function initMap() {
        const defaultLocation = { lat: 6.5244, lng: 3.3792 }; // fallback
        map = new google.maps.Map(document.getElementById("map"), {
          center: defaultLocation,
          zoom: 2,
        });

        marker = new google.maps.marker.AdvancedMarkerElement({
          map,
          position: defaultLocation,
          draggable: true,
        });

        // Drag to update coords + reverse-geocode
        marker.addListener("dragend", () => {
          const pos = marker.position;
          updateLatLng(pos.lat, pos.lng);
          reverseGeocode(pos.lat, pos.lng);
        });

        // Autocomplete setup
        autocomplete = new google.maps.places.PlaceAutocompleteElement({
          input: document.getElementById("autocomplete"),
        });
        autocomplete.addListener("place_changed", () => {
          const place = autocomplete.getPlace();
          if (!place.geometry) return;

          const loc = place.geometry.location;
          map.setCenter(loc);
          map.setZoom(16);
          marker.position = loc;

          updateLatLng(loc.lat(), loc.lng());
          fillAddressComponents(place);
        });
      }

      function updateLatLng(lat, lng) {
        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;
      }

      function reverseGeocode(lat, lng) {
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ location: { lat, lng } }, (results, status) => {
          if (status === "OK" && results[0]) {
            fillAddressComponents(results[0]);
          }
        });
      }

      function fillAddressComponents(place) {
        const comps = {
          street_number: "",
          route: "",
          locality: "",
          administrative_area_level_1: "",
          country: "",
        };

        if (place.address_components) {
          place.address_components.forEach((c) => {
            const type = c.types[0];
            if (comps.hasOwnProperty(type)) {
              comps[type] = c.long_name;
            }
          });

          document.getElementById("address").value =
            `${comps.street_number} ${comps.route}`.trim();
          document.getElementById("city").value = comps.locality;
          document.getElementById("state").value = comps.administrative_area_level_1;
          document.getElementById("country").value = comps.country;
        }
      }
    </script>
  </body>
</html>
