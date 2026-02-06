<x-client-layout>

    <div class="flex-grow-1">
        <div class="container mt-4">
            <!-- Dynamic content goes here -->
            <h2 class="mb-3">Dashboard</h2>
            <p>Create and manage your events for your parish</p>
        </div>


        @if(session('success'))
            <div class="alert alert-success">{{session('success')}}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{session('error')}}</div>
        @endif

        @if($errors->any())
            @foreach ($errors->all() as $err)
                <div class="alert alert-warning">{{$err}}</div>
            @endforeach

        @endif
        <div class="p-4 mb-4">
            <div id="messageDiv"></div>
            <form action="{{route('event.create')}}" method="post" id="eventForm">
                @csrf
                <div class="mb-3">
                    <label for="title">Event Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{old('name')}}">
                    @error('title')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="20" rows="5" class="form-control">{{old('description')}}</textarea>
                    @error('description')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="time">Event date</label>
                    <input type="datetime-local" name="event_date" id="event_date" class="form-control" value="{{old('event_date')}}">
                    @error('event_date')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="">Location (optional)</label>
                    <input type="text" name="location" id="location" class="form-control" value="{{old('location')}}">
                    @error('location')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="">Picture</label>
                </div>
                <p class="text-center">
                    <button class="btn btn-primary">Create</button>
                </p>

            </form>
        </div>
    </div>

    <script>

    document.getElementById('eventForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const title = document.getElementById('title').value
        const description = document.getElementById('description').value
        const event_date = document.getElementById('event_date').value
        const messageDiv = document.getElementById('messageDiv')

        fetch("{{route('event.create')}}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}",
                'Accept': 'application/json',
                'content-type': 'application/json'
            },
            body: JSON.stringify({title: title, description: description, event_date: event_date})
        })
        .then( res => res.json() )
        .then(data => {
            if(data.success){
                messageDiv.innerHTML = `<p class='alert alert-success'>${data.message}</p>` 
                document.getElementById('eventForm').reset();
            }else{
                messageDiv.InnerHTML = `<p class='alert alert-warning'>${data.error}</p>`
            }
        })
        .catch(error => {
            messageDiv.innerHTML = `<p class='alert alert-warning'>Something went wrong, try again later!</p>`
            // console.log(error);
        })
    })
    
    </script>

</x-client-layout>
