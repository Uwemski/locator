<x-client>
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
            <form action="{{route('events.update', $event->id)}}" method="POST">
                @csrf

                @method('PUT')
                <div class="mb-3">
                    <label for="title">Event Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{$event->title}}">
                    @error('title')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="desc">Description</label>
                    <textarea name="description" id="desc" cols="20" rows="5" class="form-control">{{$event->description}}</textarea>
                    @error('description')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="time">Event date</label>
                    <input type="text" name="event_date" class="form-control" value="{{$event->event_date}}" placeholder="Format: Y-m-d">
                    @error('event_date')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="">Location (optional)</label>
                    <input type="text" name="location" id="location" class="form-control" value="{{$event->location}}">
                    @error('location')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="">Picture</label>
                </div>
                <p class="text-center">
                    <button class="btn btn-primary ">Update</button>
                </p>

            </form>
        </div>
    </div>
</x-client>
