<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <title>Parish Registration</title>
  <style>
    span{
      color: red
    }
    </style>
</head>
<body>
  <div class="container-fluid d-flex justify-content-center min-vh-80 align-items-center">
    <div class="col-md-6 col-lg-4  p-4 rounded shadow mt-5" >
     <div class="row text-center">
        <h2>User Registration</h2>
        <p>Fill out the form carefully for registration</p>
      </div>
      <div class="">
        <form action="/parish_reg" method="POST" class="p-2">
          @csrf
          <div class=" mb-3">
            <label for="name">Name<span>*</span></label>
            <input type="text" name="name" id="name" required placeholder="Enter your Parish Name" class="form-control">
          </div>

          <div class=" mb-3">
            <label for="email">Email<span>*</span></label>
            <input type="email" name="email" id="email" required placeholder="Enter your Email" class="form-control">
          </div>

          <div class=" mb-3">
            <label for="password">Password<span>*</span></label>
            <input type="password" name="password" id="pass" required placeholder="Choose a strong password" class="form-control">
          </div>

          <div class=" mb-3">
            <label for="password">Confirm Password<span>*</span></label>
            <input type="password" name="cPassword" id="cpass" required placeholder="Confirm your password" class="form-control">
          </div>

          <button type="button" id="getLocationBtn" class="btn btn-primary mb-3">Use My Location</button>
          <div id="map" style="height: 400px;" class="mb-3"></div>

          <input type="hidden" name="Latitude" id="latitude">
          <input type="hidden" name="Longitude" id="longitude">

          <div class="mb-3">
            <label>Address</label>
            <input type="text" name="address" id="address" class="form-control" required>
          </div>

          <div class="mb-3">
              <label>City</label>
              <input type="text" name="city" id="city" class="form-control" required>
          </div>

          <div class="mb-3">
              <label>State</label>
              <input type="text" name="state" id="state" class="form-control" required>
          </div>

          <div class="mb-3">
              <label>Country</label>
              <input type="text" name="country" id="country" class="form-control" required>
          </div>

          <!-- Add other fields like name, pastor_name, etc. -->

          <button type="submit" class="btn btn-success">Submit</button>
        </form>
      </div>
      
    </div>
  </div>



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

  let myForm = document.querySelector('form');
  // myForm.addEventListener('submit', function(e){
  //   e.preventDefault();

  //   let name = document.getElementById('name')
  //   let lat = document.getElementById('latitude')
  //   let long = document.getElementById('Longitude')
  //   let address =  document.getElementById('address')
  //   let city =  document.getElementById('city')
  //   let state = document.getElementById('state')
  //   let country =  document.getElementById('country')

  //   if ()

  // })

  function reverseGeocode(lat, lng) {
      fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
          .then(res => res.json())
          .then(data => {
              alert(data)
              console.log(data)
              if (data.address) {
                  document.getElementById('address').value = data.address.road || '';
                  document.getElementById('city').value = data.address.city || data.address.town || data.address.village || '';
                  document.getElementById('state').value = data.address.state || '';
                  document.getElementById('country').value = data.address.country || '';
              }
          });
  }

  //console.log(myForm);
  </script>
</body>
</html>