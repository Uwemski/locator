<x-client>
    

    <div class="flex-grow-1">
        <div class="container mt-4">
            <!-- Dynamic content goes here -->
            <h2 class="mb-3">Dashboard</h2>
            <p>Create Services for your Parish: This helps for users and visitors  to know when service will hold</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success p-2">{{session('success')}}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-warning p-2">{{session('error')}}</div>
        @endif

       <div class="col-md-9">
        @if($errors->any())
            @foreach ($errors->all() as $err)
                <div class="alert alert-warning">{{$err}}</div>
            @endforeach
        @endif
            <form action="{{route('services.create')}}" method="post" class="p-3" id="serviceForm">
                @csrf
                <div class="mb-3">
                    <label for="name">Service Name</label>
                    <input type="text" name="name" id="name" class="form-control" required placeholder="Digging deep, faith clinic" value="{{old('name')}}">
                    @error('name')
                        <small style='color:red'>{{$message}}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="time">Time</label>
                    <input type="time" name="time" id="time" class="form-control" required placeholder="Time..." value="{{old('time')}}">
                    @error('time')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="day">Day</label>
                    <select name="day" id="day" class="form-select">
                        <option value="">Select a day</option>
                        <option value="Sunday">Sunday</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                    </select>
                    @error('day')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Create</button>
            </form>
            <div id="resultDiv"></div>
       </div>
    </div>

    <script>
        document.getElementById('serviceForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('name').value;
            const time = document.getElementById('time').value;
            const day = document.getElementById('day').value;

            const resultDiv = document.getElementById('resultDiv');

            fetch("{{route('services.create')}}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token() }}",
                    'Accept': 'application/json',
                    'Content-type': 'application/json'
                },
                body: JSON.stringify({name: name, time: time, day: day})
            })
            .then(response => response.json())
            .then(data => {
                if(data.success){ 
                    resultDiv.innerHTML = `<p style='color:green'>${data.message}</p> `;
                    document.getElementById('serviceForm').reset();
                } else {
                    resultDiv.innerHTML = `<p style="color:red">${data.error}</p>`;
                }
            })
            .catch(error => {
                console.error(error);
                resultDiv.innerHTML = `<p style="color:red">Something went wrong</p>`;
            });
            // console.log(name, time, day); working
        })
    </script>
</x-client>
