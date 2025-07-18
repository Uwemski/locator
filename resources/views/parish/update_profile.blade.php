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

                    {{-- <h2>Select a location on the map</h2>
                    <div id="map"></div> --}}

                    @if(session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-warning">{{session('error')}}</div>
                    @endif   
                    @if ($errors->any())
                        @foreach ($errors->all() as $err)
                            <div class="alert alert-warning">{{$err}}</div>
                        @endforeach
                    @endif
                    <form action="/parish/update_profile" method="post">
                        @csrf
                        @method('PUT')
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
                            <input type="text" name="contact_no" id="contact" class="form-control" placeholder="Contact number" value="{{old('contact_no')}}">
                            @error("contact_no")
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="wewbsite">Website</label>
                            <input type="text" name="website" id="website" class="form-control" placeholder="website address(optional)" value="{{old('website')}}">
                            @error("website")
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
            {{-- <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script> --}}
            <script>
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

                    if(!(address) || !(pastor_name) || !(contact_no) || !(latitude) || !(longitude) ){
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





