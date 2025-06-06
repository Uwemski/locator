<!--Header starts here-->

@include('partials.parish_header')
<!--Header ends here-->
    <body>
        <div class="d-flex">
            <!-- Sidebar -->
            @include('partials.parish_sidebar')
            <!--SIDEBAR ENDS HERE-->

            <!-- Main Content -->
            <div class="flex-grow-1">
                <nav class="navbar navbar-expand-lg header px-3">
                    <button class="btn btn-outline-dark d-md-none" onclick="toggleSidebar()">☰</button>
                    <span class="ms-3 fw-bold">Welcome, Parish Admin</span>
                </nav>

                <div class="container mt-4">
                    <!-- Dynamic content goes here -->
                    <h2 class="mb-3">Dashboard</h2>
                    <p>This is your parish dashboard. You can manage your profile, services, location and more.</p>

                    <h2>Select a location on the map</h2>
                    <div id="map"></div>


                    @if ($errors->any())
                        @foreach ($errors->all() as $err)
                            <div class="alert alert-warning">{{$err}}</div>
                        @endforeach
                    @endif
                    <form action="" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="address">Address</label>
                            <input type="text" name="address" id="address" class="form-control" required placeholder="Enter your address here" value="{{old('address')}}">
                           @error('address')
                            <small style='color: red'>{{$message}}</small>
                           @enderror
                        </div>
                        <div class="mb-3">
                            <label for="">Pastor's Name</label>
                            <input type="text" name="pastor_name" id="p-name" class="form-control" required placeholder="Pastor in charge?" value="{{old('pastor_name')}}">
                            @error("pastor_name")
                                <small style="color:red">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="contact">Contact Number</label>
                            <input type="text" name="contact_number" id="contact" class="form-control" placeholder="Contact number" value="{{old('contact_number')}}">
                            @error("conatct_number")
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="wewbsite">Website</label>
                            <input type="text" name="website_url" id="website" class="form-control" placeholder="website address(optional)" value="{{old('website_url')}}">
                            @error("website_url")
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="latitude">Latitude</label>
                            <input type="text" name="latitude" id="latitude" class="form-control" placeholder="latitude" readonly value="{{old('latitude')}}">
                            @error("latitude")
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="longitude">Longitude</label>
                            <input type="text" name="longitude" id="longitude" class="form-control" placeholder="longitude" readonly value="{{old('longitude')}}">
                            @error("longitude")
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                        <p class="text-center">
                            <button type="submit" class="btn btn-success">Update Profile</button>
                        </p>
                        
                    </form>
                </div>
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

                function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('show');
                }

                let form = querySelector('form');
                
                form.addEventListener('submit', function(e){
                    e.preventDefault();

                    let address, pastor_name, contact_number, latitude, longitude;
                    address = document.getElementById('address').value.trim();
                    pastor_name = document.getElementById('p-name').value.trim();
                    contact_number = document.getElementById('contact').value.trim();
                    latitude = document.getElementById('latitude').value.trim();
                    longitude= document.getElementById('longitude').value.trim();

                    if(!(addess) || (pastor-pastor_name) || !(contact_number) || !(latitude) || !(longitude) ){
                        alert("All fields are required!")
                    }else{
                        alert("Submitting form...");
                        form.submit();
                    }
                })
            </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>





