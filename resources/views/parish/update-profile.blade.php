<!--Header starts here-->
<x-client>


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
                    <form action="{{route('parish.update.profile')}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="address">Address</label>
                            <input type="text" name="address" id="address" class="form-control" required placeholder="Enter your address here" value="{{$parish->address}}">
                           @error('address')
                            <small style='color: red'>{{$message}}</small>
                           @enderror
                        </div>
                        <div class="mb-3">
                            <label for="">Pastor's Name</label>
                            <input type="text" name="pastor_name" id="p-name" class="form-control" required placeholder="Pastor in charge?" value="{{$parish->pastor_name}}">
                            @error("pastor_name")
                                <small style="color:red">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="contact">Contact Number</label>
                            <input type="text" name="contact_no" id="contact" class="form-control" placeholder="Contact number" value="{{$parish->contact_no}}">
                            @error("contact_no")
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="wewbsite">Website</label>
                            <input type="text" name="website" id="website" class="form-control" placeholder="website address(optional)" value="{{$parish->website}}">
                            @error("website")
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                        <p class="text-center">
                            <button type="submit" class="btn btn-success">Update Profile</button>
                        </p>
                        
                    </form>
                </div>

        <script>
                let form = document.querySelector('form');
                
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
</x-client>